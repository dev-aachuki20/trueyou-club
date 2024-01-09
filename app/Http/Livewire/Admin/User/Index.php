<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    public $search = '', $formMode = false, $updateMode = false, $viewMode = false;

    public $contact_id = null, $first_name,  $last_name, $phone_number, $email, $message, $status = 1;

    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm'
    ];

    public function mount()
    {
        abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    // public function updatedPublishDate()
    // {
    //     $this->publish_date = Carbon::parse($this->publish_date)->format('d-m-Y');
    // }
    public function render()
    {
        return view('livewire.admin.user.index');
    }

    // public function create()
    // {
    //     $this->initializePlugins();
    //     $this->formMode = true;
    // }

    // public function store()
    // {
    //     $validatedData = $this->validate([
    //         'title'        => 'required',
    //         'publish_date' => 'required',
    //         'content'      => 'required|strip_tags',
    //         'status'       => 'required',
    //         'image'        => 'nullable|image|max:' . config('constants.img_max_size'),
    //     ], [
    //         'content.strip_tags' => 'The content field is required',
    //     ]);

    //     DB::beginTransaction();
    //     try {

    //         $validatedData['publish_date']   = Carbon::parse($this->publish_date)->format('Y-m-d');

    //         $validatedData['status'] = $this->status;

    //         $blog = Blog::create($validatedData);

    //         if ($this->image) {
    //             //Upload Image
    //             uploadImage($blog, $this->image, 'blog/image/', "blog", 'original', 'save', null);
    //         }

    //         $this->formMode = false;

    //         DB::commit();

    //         $this->reset(['title', 'publish_date', 'content', 'status', 'image']);

    //         $this->flash('success', trans('messages.add_success_message'));

    //         return redirect()->route('admin.blogs');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         $this->alert('error', trans('messages.error_message'));
    //     }
    // }

    // public function edit($id)
    // {
    //     $this->initializePlugins();
    //     $this->formMode = true;
    //     $this->updateMode = true;

    //     $blog = Blog::findOrFail($id);
    //     $this->blog_id         =  $blog->id;
    //     $this->title           =  $blog->title;
    //     $this->publish_date    =  Carbon::parse($blog->publish_date)->format('d-m-Y');
    //     $this->content         =  $blog->content;
    //     $this->status          =  $blog->status;
    //     $this->originalImage   =  $blog->image_url;
    // }


    // public function update()
    // {
    //     $rules['title']        = 'required';
    //     $rules['publish_date'] = 'required';
    //     $rules['content']      = 'required|strip_tags';
    //     $rules['status']       = 'required';

    //     if ($this->image) {
    //         $rules['image'] = 'nullable|image|max:' . config('constants.img_max_size');
    //     }

    //     $validatedData = $this->validate($rules, [
    //         'meeting_link.strip_tags' => 'The meeting_link field is required',
    //     ]);

    //     $validatedData['publish_date']   = Carbon::parse($this->publish_date)->format('Y-m-d');
    //     $validatedData['status'] = $this->status;

    //     DB::beginTransaction();
    //     try {

    //         $blog = Blog::find($this->blog_id);

    //         // Check if the image has been changed
    //         if ($this->image) {
    //             if ($blog->blogImage) {
    //                 $uploadImageId = $blog->blogImage->id;
    //                 uploadImage($blog, $this->image, 'blog/image/', "blog", 'original', 'update', $uploadImageId);
    //             } else {
    //                 uploadImage($blog, $this->image, 'blog/image/', "blog", 'original', 'save', null);
    //             }
    //         }

    //         if ($this->removeImage) {
    //             if ($blog->blogImage) {
    //                 $uploadImageId = $blog->blogImage->id;
    //                 deleteFile($uploadImageId);
    //             }
    //         }

    //         $blog->update($validatedData);

    //         $this->formMode = false;
    //         $this->updateMode = false;

    //         DB::commit();

    //         $this->flash('success', trans('messages.edit_success_message'));

    //         $this->reset(['title', 'publish_date', 'content', 'status', 'image']);

    //         return redirect()->route('admin.blogs');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         $this->alert('error', trans('messages.error_message'));
    //     }
    // }

    public function show($id)
    {
        $this->contact_id = $id;
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
        $model    = Contact::find($deleteId);
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
            'inputAttributes' => ['contactId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $contactId = $event['data']['inputAttributes']['contactId'];
        $model = Contact::find($contactId);
        $model->update(['status' => !$model->status]);

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal)
    {
        $this->status = (!$statusVal) ? 1 : 0;
    }
}
