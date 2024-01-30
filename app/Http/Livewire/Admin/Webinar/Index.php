<?php

namespace App\Http\Livewire\Admin\Webinar;

use App\Models\User;
use Gate;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Webinar;
use App\Notifications\WebinarCreated;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    protected $layout = null;

    public $search = '', $formMode = false , $updateMode = false, $viewMode = false;

    public $webinar_id=null, $title,  $start_date = null, $start_time=null,  $end_time = null, $meeting_link, $image, $originalImage, $status=1,$full_start_time=null,  $full_end_time = null;

    public $removeImage = false, $showJoinBtn = false;

    protected $listeners = [
        'cancel','show', 'edit', 'toggle', 'confirmedToggleAction','delete','deleteConfirm'
    ];

    public function mount(){
        abort_if(Gate::denies('webinar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function updatedStartDate(){
        $this->start_date = Carbon::parse($this->start_date)->format('d-m-Y');
    }

    public function updatedStartTime(){
        if($this->start_time){
            $this->start_time = Carbon::parse($this->start_time)->format('h:i A');
        }
    }


    public function updatedEndTime(){
        if($this->end_time){
            $this->end_time = Carbon::parse($this->end_time)->format('h:i A');
        }
    }

    public function render()
    {
        return view('livewire.admin.webinar.index');
    }

    public function create()
    {
        $this->initializePlugins();
        $this->formMode = true;
    }

    public function store(){
        
        $rules = [
            'title'        => 'required',
            'start_date'   => 'required|date',
            'start_time'   => 'required|date_format:h:i A',
            'end_time'     => 'required|date_format:h:i A',
            'meeting_link' => 'required|url',
            // 'status'      => 'required',
            'image'       => 'nullable|image|max:'.config('constants.img_max_size'),
        ];
        
        $starDateTime = Carbon::parse($this->start_date.' '.$this->start_time);
        $endDateTime = Carbon::parse($this->start_date.' '.$this->end_time);
        $currentDateTime = Carbon::now();

        // Check if start time is greater than current time
        if ($starDateTime->lt($currentDateTime)) {
            $rules['start_time'] = '|after:now';
        }

        // Check if end time is greater than start time
        if ($endDateTime->lt($starDateTime)) {
            $rules['end_time'] = '|after:start_time';
        }

        $validatedData = $this->validate($rules,[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
            'end_time.after' => 'The end time must be a time after the start time.',
        ]);


        $validatedData['start_date']   = Carbon::parse($this->start_date)->format('Y-m-d');
        $validatedData['start_time']   = Carbon::parse($this->start_time)->format('H:i');
        $validatedData['end_time']   = Carbon::parse($this->end_time)->format('H:i');

        // $validatedData['status'] = $this->status;

        $webinar = Webinar::create($validatedData);

        $users = User::whereHas('roles', function($q){ $q->where('title', 'User');})->get();
        Notification::send($users, new WebinarCreated($webinar));

        //Upload Image
        if ($this->image) {
            uploadImage($webinar, $this->image, 'webinar/image/',"webinar", 'original', 'save', null);
        }

        $this->formMode = false;

        $this->reset();

        $this->flash('success',trans('messages.add_success_message'));

        return redirect()->route('admin.webinars');
    }

    public function edit($id)
    {

        $this->formMode = true;
        $this->updateMode = true;

        $webinar = Webinar::findOrFail($id);
        $this->webinar_id      =  $webinar->id;
        $this->title           =  $webinar->title;
        $this->start_date      =  Carbon::parse($webinar->start_date)->format('d-m-Y');
        $this->start_time      =  Carbon::parse($webinar->start_time)->format('h:i A');
        $this->end_time        =  Carbon::parse($webinar->end_time)->format('h:i A');
        $this->meeting_link    =  $webinar->meeting_link;
        $this->status          =  $webinar->status;
        $this->originalImage   =  $webinar->image_url;

        $this->full_start_time =  Carbon::parse($webinar->start_date.' '.$webinar->start_time)->format('Y-m-d H:i:s');
        $this->full_end_time   =  Carbon::parse($webinar->start_date.' '.$webinar->end_time)->format('Y-m-d H:i:s');
        
        $this->initializePlugins();
    }


    public function update(){
        $rules['title']        = 'required';
        $rules['start_date']   = 'required|date';
        $rules['start_time']   = 'required|date_format:h:i A';
        $rules['end_time']     = 'required|date_format:h:i A|after:start_time';
        $rules['meeting_link'] = 'required|url';
        // $validatedArray['status']       = 'required';

        if($this->image || $this->removeImage){
            $rules['image'] = 'nullable|image|max:'.config('constants.img_max_size');
        }

        $starDateTime = Carbon::parse($this->start_date.' '.$this->start_time);
        $endDateTime = Carbon::parse($this->start_date.' '.$this->end_time);
        $currentDateTime = Carbon::now();

        // Check if start time is greater than current time
        if ($starDateTime->lt($currentDateTime)) {
            $rules['start_time'] = '|after:now';
        }

        // Check if end time is greater than start time
        if ($endDateTime->lt($starDateTime)) {
            $rules['end_time'] = '|after:start_time';
        }

        $validatedData = $this->validate($rules,[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
            'end_time.after' => 'The end time must be a time after the start time.',
        ]);

        $validatedData['start_date']   = Carbon::parse($this->start_date)->format('Y-m-d');
        $validatedData['start_time']   = Carbon::parse($this->start_time)->format('H:i');

        $validatedData['end_time']   = Carbon::parse($this->end_time)->format('H:i');

        // $validatedData['status'] = $this->status;

        $webinar = Webinar::find($this->webinar_id);

        // Check if the image has been changed
      
        if ($this->image) {
            if($webinar->webinarImage){
                $uploadImageId = $webinar->webinarImage->id;
                uploadImage($webinar, $this->image, 'webinar/image/',"webinar", 'original', 'update', $uploadImageId);
            }else{
                uploadImage($webinar, $this->image, 'webinar/image/',"webinar", 'original', 'save', null);
            }
        }

        if($this->removeImage){
            if($webinar->webinarImage){
                $uploadImageId = $webinar->webinarImage->id;
                deleteFile($uploadImageId);
            }
        }

        $webinar->update($validatedData);

        $this->formMode = false;
        $this->updateMode = false;

        $this->flash('success',trans('messages.edit_success_message'));

        $this->reset();

        return redirect()->route('admin.webinars');
    }

    public function show($id){
        $this->webinar_id = $id;
        $this->formMode = false;
        $this->viewMode = true;
    }


    public function initializePlugins(){
        $data = [
            'updateMode' => $this->updateMode, 
            'full_start_time' => $this->full_start_time,
            'full_end_time' => $this->full_end_time,
        ];
        $this->dispatchBrowserEvent('loadPlugins', $data);
    }

    public function cancel(){
        $this->reset();
        $this->resetValidation();

        $this->dispatchBrowserEvent('webinarCounterEvent');
    }

    public function delete($id)
    {
        $this->confirm('Are you sure?', [
            'text'=>'You want to delete it.',
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'No, cancel!',
            'onConfirmed' => 'deleteConfirm',
            'onCancelled' => function () {
                // Do nothing or perform any desired action
            },
            'inputAttributes' => ['deleteId' => $id],
        ]);
    }

    public function deleteConfirm($event){
        $deleteId = $event['data']['inputAttributes']['deleteId'];
        $model    = Webinar::find($deleteId);
        $model->delete();

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.delete_success_message'));
    }

    public function toggle($id){
        $this->confirm('Are you sure?', [
            'text'=>'You want to change the status.',
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' => 'Yes Confirm!',
            'cancelButtonText' => 'No Cancel!',
            'onConfirmed' => 'confirmedToggleAction',
            'onCancelled' => function () {
                // Do nothing or perform any desired action
            },
            'inputAttributes' => ['webinarId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $webinarId = $event['data']['inputAttributes']['webinarId'];
        $model = Webinar::find($webinarId);
        $model->update(['status' => !$model->status]);

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal){
        $this->status = (!$statusVal) ? 1 : 0;
    }

}
