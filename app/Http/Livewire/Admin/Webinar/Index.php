<?php

namespace App\Http\Livewire\Admin\Webinar;

use Gate;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Webinar;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    protected $layout = null;

    public $search = '', $formMode = false , $updateMode = false, $viewMode = false;

    public $webinar_id=null, $title,  $start_date = null, $start_time=null, $end_date = null, $end_time = null, $meeting_link, $image, $originalImage, $status=1;

    public $removeImage = false, $showJoinBtn = false;

    protected $listeners = [
        'cancel','show', 'edit', 'toggle', 'confirmedToggleAction','delete','deleteConfirm'
    ];

    public function mount(){
        abort_if(Gate::denies('webinar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->start_date = Carbon::now()->format('d-m-Y');
        $this->start_time = Carbon::now()->format('h:i A');
        $this->end_date = Carbon::now()->format('d-m-Y');
        $this->end_time = Carbon::now()->format('h:i A');
    }

    public function updatedStartDate(){
        $this->start_date = Carbon::parse($this->start_date)->format('d-m-Y');
        $this->end_date = Carbon::parse($this->start_date)->format('d-m-Y');
    }

    public function updatedStartTime(){
        $this->start_time = Carbon::parse($this->start_time)->format('h:i A');
        $this->end_time = Carbon::parse($this->start_time)->format('h:i A');

    }

    public function updatedEndDate(){
        $this->end_date = Carbon::parse($this->end_date)->format('d-m-Y');
    }

    public function updatedEndTime(){
        $this->end_time = Carbon::parse($this->end_time)->format('h:i A');
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
            'end_date'     => 'required|date|after_or_equal:start_date',
            'end_time'     => 'required|date_format:h:i A',
            'meeting_link' => 'required|url',
            // 'status'      => 'required',
            'image'       => 'nullable|image|max:'.config('constants.img_max_size'),
        ];
        
        $endDate = Carbon::parse($this->end_date)->format('Y-m-d');

        // Check if end_date is today
        if ($endDate == now()->toDateString()) {
            // If it is today, add the 'after:start_time' rule to end_time
            $rules['end_time'] .= '|after:start_time';
        }

        $validatedData = $this->validate($rules,[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
            'end_time.after' => 'The end time must be a time after the start time.',
        ]);


        $validatedData['start_date']   = Carbon::parse($this->start_date)->format('Y-m-d');
        $validatedData['start_time']   = Carbon::parse($this->start_time)->format('H:i');

        $validatedData['end_date']   = $endDate;
        $validatedData['end_time']   = Carbon::parse($this->end_time)->format('H:i');

        // $validatedData['status'] = $this->status;

        $webinar = Webinar::create($validatedData);

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
        $this->initializePlugins();
        $this->formMode = true;
        $this->updateMode = true;

        $webinar = Webinar::findOrFail($id);
        $this->webinar_id      =  $webinar->id;
        $this->title           =  $webinar->title;
        $this->start_date      =  Carbon::parse($webinar->start_date)->format('d-m-Y');
        $this->start_time      =  Carbon::parse($webinar->start_time)->format('h:i A');
        $this->end_date        =  Carbon::parse($webinar->end_date)->format('d-m-Y');
        $this->end_time        =  Carbon::parse($webinar->end_time)->format('h:i A');
        $this->meeting_link    =  $webinar->meeting_link;
        $this->status          =  $webinar->status;
        $this->originalImage   =  $webinar->image_url;

    }


    public function update(){
        $rules['title']        = 'required';
        $rules['start_date']   = 'required|date';
        $rules['start_time']   = 'required|date_format:h:i A';
        $rules['end_date']     = 'required|date|after_or_equal:start_date';
        $rules['end_time']     = 'required|date_format:h:i A';
        $rules['meeting_link'] = 'required|url';
        // $validatedArray['status']       = 'required';

        if($this->image || $this->removeImage){
            $rules['image'] = 'nullable|image|max:'.config('constants.img_max_size');
        }

        $endDate = Carbon::parse($this->end_date)->format('Y-m-d');

        // Check if end_date is today
        if ($endDate == now()->toDateString()) {
            // If it is today, add the 'after:start_time' rule to end_time
            $rules['end_time'] .= '|after:start_time';
        }

        $validatedData = $this->validate($rules,[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
            'end_time.after' => 'The end time must be a time after the start time.',
        ]);

        $validatedData['start_date']   = Carbon::parse($this->start_date)->format('Y-m-d');
        $validatedData['start_time']   = Carbon::parse($this->start_time)->format('H:i');

        $validatedData['end_date']   = $endDate;
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
        $this->dispatchBrowserEvent('loadPlugins');
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
