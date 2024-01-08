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

    public $webinar_id=null, $title,  $date = null, $time=null, $meeting_link, $image, $originalImage, $status=1;

    public $removeImage = false;

    protected $listeners = [
        'cancel','show', 'edit', 'toggle', 'confirmedToggleAction','delete','deleteConfirm'
    ];

    public function mount(){
        abort_if(Gate::denies('webinar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function updatedDate(){
        $this->date = Carbon::parse($this->date)->format('d-m-Y');
    }

    public function updatedTime(){
        $this->time = Carbon::parse($this->time)->format('h:i A');
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
        $validatedData = $this->validate([
            'title'        => 'required',
            'date'         => 'required',
            'time'         => 'required',
            'meeting_link' => 'required|url',
            'status'      => 'required',
            'image'       => 'required|image|max:'.config('constants.img_max_size'),
        ],[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
        ]);

        $validatedData['date']   = Carbon::parse($this->date)->format('Y-m-d');
        $validatedData['time']   = Carbon::parse($this->time)->format('H:i');

        $validatedData['status'] = $this->status;

        $webinar = Webinar::create($validatedData);

        //Upload Image
        uploadImage($webinar, $this->image, 'webinar/image/',"webinar", 'original', 'save', null);

        $this->formMode = false;

        $this->reset(['title','date','time','meeting_link','status','image']);

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
        $this->date            =  Carbon::parse($webinar->date)->format('d-m-Y');
        $this->time            =  Carbon::parse($webinar->time)->format('h:i A');
        $this->meeting_link    =  $webinar->meeting_link;
        $this->status         =  $webinar->status;
        $this->originalImage  =  $webinar->image_url;

    }


    public function update(){
        $validatedArray['title']        = 'required';
        $validatedArray['date']         = 'required';
        $validatedArray['time']         = 'required';
        $validatedArray['meeting_link'] = 'required|url';
        $validatedArray['status']      = 'required';

        if($this->image || $this->removeImage){
            $validatedArray['image'] = 'required|image|max:'.config('constants.img_max_size');
        }

        $validatedData = $this->validate($validatedArray,[
            'meeting_link.strip_tags'=> 'The meeting link field is required',
        ]);

        $validatedData['date']   = Carbon::parse($this->date)->format('Y-m-d');
        $validatedData['time']   = Carbon::parse($this->time)->format('H:i');
        $validatedData['status'] = $this->status;

        $webinar = Webinar::find($this->webinar_id);

        // Check if the image has been changed
        $uploadImageId = null;
        if ($this->image) {
            $uploadImageId = $webinar->webinarImage->id;
            uploadImage($webinar, $this->image, 'webinar/image/',"webinar", 'original', 'update', $uploadImageId);
        }


        $webinar->update($validatedData);

        $this->formMode = false;
        $this->updateMode = false;

        $this->flash('success',trans('messages.edit_success_message'));

        $this->reset(['title','date','time','meeting_link','status','image']);

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
