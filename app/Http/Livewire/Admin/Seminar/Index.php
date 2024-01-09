<?php

namespace App\Http\Livewire\Admin\Seminar;

use App\Models\Seminar;
use Gate;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;


class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    protected $layout = null;

    public $search = '', $formMode = false, $updateMode = false, $viewMode = false;

    public $seminar_id = null, $title,  $date = null, $time = null, $venue, $image, $originalImage, $status = 1;

    public $removeImage = false;

    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm'
    ];

    public function mount()
    {
        abort_if(Gate::denies('seminar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->date = Carbon::now()->format('d-m-Y');
        $this->time = Carbon::now()->format('h:i A');
    }

    public function updatedDate()
    {
        $this->date = Carbon::parse($this->date)->format('d-m-Y');
    }

    public function updatedTime()
    {
        $this->time = Carbon::parse($this->time)->format('h:i A');
    }
    public function render()
    {
        return view('livewire.admin.seminar.index');
    }

    public function create()
    {
        $this->initializePlugins();
        $this->formMode = true;
    }

    public function store()
    {
        $validatedData = $this->validate(
            [
                'title'        => 'required',
                'date'         => 'required',
                'time'         => 'required',
                'venue'        => 'required',
                'status'       => 'required',
                'image'        => 'nullable|image|max:' . config('constants.img_max_size'),
            ],
            // [
            //     'meeting_link.strip_tags' => 'The meeting link field is required',
            // ]
        );

        $validatedData['date']   = Carbon::parse($this->date)->format('Y-m-d');
        $validatedData['time']   = Carbon::parse($this->time)->format('H:i');

        $validatedData['status'] = $this->status;

        $seminar = Seminar::create($validatedData);

        //Upload Image
        if ($this->image) {
            uploadImage($seminar, $this->image, 'seminar/image/', "seminar", 'original', 'save', null);
        }

        $this->formMode = false;

        $this->reset(['title', 'date', 'time', 'venue', 'status', 'image']);

        $this->flash('success', trans('messages.add_success_message'));

        return redirect()->route('admin.seminars');
    }

    public function edit($id)
    {
        $this->initializePlugins();
        $this->formMode = true;
        $this->updateMode = true;


        $seminar = Seminar::findOrFail($id);
        $this->seminar_id      =  $seminar->id;
        $this->title           =  $seminar->title;
        $this->date            =  Carbon::parse($seminar->date)->format('d-m-Y');
        $this->time            =  Carbon::parse($seminar->time)->format('h:i A');
        $this->venue           =  $seminar->venue;
        $this->status          =  $seminar->status;
        $this->originalImage   =  $seminar->image_url;
    }


    public function update()
    {
        $validatedArray['title']        = 'required';
        $validatedArray['date']         = 'required';
        $validatedArray['time']         = 'required';
        $validatedArray['venue']        = 'required';
        $validatedArray['status']       = 'required';

        if ($this->image || $this->removeImage) {
            $validatedArray['image'] = 'nullable|image|max:' . config('constants.img_max_size');
        }

        // $validatedData = $this->validate($validatedArray, [
        //     'meeting_link.strip_tags' => 'The meeting link field is required',
        // ]);

        $validatedData['title']  = $this->title;
        $validatedData['venue']  = $this->venue;
        $validatedData['date']   = Carbon::parse($this->date)->format('Y-m-d');
        $validatedData['time']   = Carbon::parse($this->time)->format('H:i');
        $validatedData['status'] = $this->status;

        $seminar = Seminar::find($this->seminar_id);
        // Check if the image has been changed
        $uploadImageId = null;
        if ($this->image) {
            $uploadImageId = $seminar->seminarImage->id;
            uploadImage($seminar, $this->image, 'seminar/image/', "seminar", 'original', 'update', $uploadImageId);
        }

        $seminar->update($validatedData);

        $this->formMode = false;
        $this->updateMode = false;

        $this->flash('success', trans('messages.edit_success_message'));

        $this->reset(['title', 'date', 'time', 'venue', 'status', 'image']);

        return redirect()->route('admin.seminars');
    }

    public function show($id)
    {
        $this->seminar_id = $id;
        $this->formMode = false;
        $this->viewMode = true;
    }


    public function initializePlugins()
    {
        $this->dispatchBrowserEvent('loadPlugins');
    }

    public function cancel()
    {
        $this->reset();
        $this->resetValidation();

        $this->dispatchBrowserEvent('seminarCounterEvent');
    }

    public function delete($id)
    {
        $this->confirm('Are you sure?', [
            'text' => 'You want to delete it.',
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

    public function deleteConfirm($event)
    {
        $deleteId = $event['data']['inputAttributes']['deleteId'];
        $model    = Seminar::find($deleteId);
        $model->delete();

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.delete_success_message'));
    }

    public function toggle($id)
    {
        $this->confirm('Are you sure?', [
            'text' => 'You want to change the status.',
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' => 'Yes Confirm!',
            'cancelButtonText' => 'No Cancel!',
            'onConfirmed' => 'confirmedToggleAction',
            'onCancelled' => function () {
                // Do nothing or perform any desired action
            },
            'inputAttributes' => ['seminarId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $seminarId = $event['data']['inputAttributes']['seminarId'];
        $model = Seminar::find($seminarId);
        $model->update(['status' => !$model->status]);

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal)
    {
        $this->status = (!$statusVal) ? 1 : 0;
    }
}
