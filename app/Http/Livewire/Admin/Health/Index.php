<?php

namespace App\Http\Livewire\Admin\Health;

use App\Models\Health;
use Gate;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    public $search = '', $formMode = false, $updateMode = false, $viewMode = false;

    public $health_id = null, $title,  $publish_date = null,  $content, $image, $originalImage, $status = 1;

    public $removeImage = false;

    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm'
    ];

    public function mount()
    {
        abort_if(Gate::denies('health_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->publish_date = Carbon::now()->format('d-m-Y');
    }

    public function updatedPublishDate()
    {
        $this->publish_date = Carbon::parse($this->publish_date)->format('d-m-Y');
    }
    public function render()
    {
        return view('livewire.admin.health.index');
    }

    public function create()
    {
        $this->initializePlugins();
        $this->formMode = true;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'title'        => 'required',
            'publish_date' => 'required',
            'content'      => 'required|strip_tags',
            'status'       => 'required',
            'image'        => 'nullable|image|max:' . config('constants.img_max_size'),
        ], [
            'content.strip_tags' => 'The content field is required',
        ]);

        DB::beginTransaction();
        try {

            $validatedData['publish_date']   = Carbon::parse($this->publish_date)->format('Y-m-d');

            $validatedData['status'] = $this->status;

            $health = Health::create($validatedData);

            if ($this->image) {
                uploadImage($health, $this->image, 'health/image/', "health", 'original', 'save', null);
            }

            $this->formMode = false;

            DB::commit();

            $this->reset(['title', 'publish_date', 'content', 'status', 'image']);

            $this->flash('success', trans('messages.add_success_message'));

            return redirect()->route('admin.health');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', trans('messages.error_message'));
        }
    }

    public function edit($id)
    {
        $this->initializePlugins();
        $this->formMode = true;
        $this->updateMode = true;

        $health = Health::findOrFail($id);
        $this->health_id       =  $health->id;
        $this->title           =  $health->title;
        $this->publish_date    =  Carbon::parse($health->publish_date)->format('d-m-Y');
        $this->content         =  $health->content;
        $this->status          =  $health->status;
        $this->originalImage   =  $health->image_url;
    }


    public function update()
    {
        $rules['title']        = 'required';
        $rules['publish_date'] = 'required';
        $rules['content']      = 'required|strip_tags';
        $rules['status']       = 'required';

        if ($this->image) {
            $rules['image'] = 'nullable|image|max:' . config('constants.img_max_size');
        }

        $validatedData = $this->validate($rules, [
            'meeting_link.strip_tags' => 'The meeting_link field is required',
        ]);

        $validatedData['publish_date']   = Carbon::parse($this->publish_date)->format('Y-m-d');
        $validatedData['status'] = $this->status;

        DB::beginTransaction();
        try {

            $health = Health::find($this->health_id);

            // Check if the image has been changed
            if ($this->image) {
                if ($health->healthImage) {
                    $uploadImageId = $health->healthImage->id;
                    uploadImage($health, $this->image, 'health/image/', "health", 'original', 'update', $uploadImageId);
                } else {
                    uploadImage($health, $this->image, 'health/image/', "health", 'original', 'save', null);
                }
            }

            if ($this->removeImage) {
                if ($health->healthImage) {
                    $uploadImageId = $health->healthImage->id;
                    deleteFile($uploadImageId);
                }
            }

            $health->update($validatedData);

            $this->formMode = false;
            $this->updateMode = false;

            DB::commit();

            $this->flash('success', trans('messages.edit_success_message'));

            $this->reset(['title', 'publish_date', 'content', 'status', 'image']);

            return redirect()->route('admin.health');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', trans('messages.error_message'));
        }
    }

    public function show($id)
    {
        $this->health_id = $id;
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
        $model    = Health::find($deleteId);
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
            'inputAttributes' => ['healthId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $healthId = $event['data']['inputAttributes']['healthId'];
        $model = Health::find($healthId);
        $model->update(['status' => !$model->status]);

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal)
    {
        $this->status = (!$statusVal) ? 1 : 0;
    }
}
