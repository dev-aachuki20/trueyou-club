<?php

namespace App\Http\Livewire\Admin\News;

use Gate;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads, WithPagination;

    public $search = '', $formMode = false, $updateMode = false, $viewMode = false;

    public $news_id = null, $title,  $publish_date = null,  $content, $image, $originalImage, $status = 1;

    public $removeImage = false;
    public $type = 'news';
    public $isButtonDisabled = false;

    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm'
    ];

    public function mount()
    {
        abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->publish_date = Carbon::now()->format('d-m-Y');
    }

    public function updatedPublishDate()
    {
        $this->publish_date = Carbon::parse($this->publish_date)->format('d-m-Y');
    }

    public function render()
    {
        return view('livewire.admin.news.index');
    }


    public function create()
    {
        $this->resetPage();
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
            $validatedData['type'] = $this->type;


            $news = Post::create($validatedData);

            if ($this->image) {
                uploadImage($news, $this->image, 'news/image/', "news", 'original', 'save', null);
            }

            $this->formMode = false;

            DB::commit();

            $this->reset(['title', 'publish_date', 'content', 'status', 'image', 'type']);

            $this->flash('success', trans('messages.add_success_message'));

            return redirect()->route('admin.news');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', trans('messages.error_message'));
        }
    }

    public function edit($id)
    {
        $this->resetPage();
        $this->initializePlugins();
        $this->formMode = true;
        $this->updateMode = true;

        $news = Post::findOrFail($id);
        $this->news_id         =  $news->id;
        $this->title           =  $news->title;
        $this->publish_date    =  Carbon::parse($news->publish_date)->format('d-m-Y');
        $this->content         =  $news->content;
        $this->status          =  $news->status;
        $this->originalImage   =  $news->news_image_url;
        $this->type            =  $news->type;
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
            'content.strip_tags' => 'The content field is required',
        ]);

        $validatedData['publish_date']   = Carbon::parse($this->publish_date)->format('Y-m-d');
        $validatedData['status'] = $this->status;
        $validatedData['type']   = $this->type;

        DB::beginTransaction();
        try {

            $news = Post::find($this->news_id);

            // Check if the image has been changed
            if ($this->image) {
                if ($news->newsImage) {
                    $uploadImageId = $news->newsImage->id;
                    uploadImage($news, $this->image, 'news/image/', "news", 'original', 'update', $uploadImageId);
                } else {
                    uploadImage($news, $this->image, 'news/image/', "news", 'original', 'save', null);
                }
            }

            if ($this->removeImage) {
                if ($news->newsImage) {
                    $uploadImageId = $news->newsImage->id;
                    deleteFile($uploadImageId);
                }
            }

            $news->update($validatedData);

            $this->formMode = false;
            $this->updateMode = false;

            DB::commit();

            $this->flash('success', trans('messages.edit_success_message'));

            $this->reset(['title', 'publish_date', 'content', 'status', 'image', 'type']);

            return redirect()->route('admin.news');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', trans('messages.error_message'));
        }
    }

    public function show($id)
    {
        $this->news_id = $id;
        $this->formMode = false;
        $this->viewMode = true;
        $this->resetPage();
    }

    public function initializePlugins()
    {
        $this->dispatchBrowserEvent('loadPlugins');
    }

    public function cancel()
    {
        $this->reset();
        $this->resetPage();
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
        // After confirmation, disable the button
        $this->isButtonDisabled = true;
    }

    public function deleteConfirm($event)
    {
        $deleteId = $event['data']['inputAttributes']['deleteId'];
        $model    = Post::find($deleteId);
        
        if(!$model){
            $this->emit('refreshTable'); 
            $this->alert('error', trans('messages.error_message'));   
        }else{
            $model->delete();
            $this->emit('refreshTable');    
            $this->alert('success', trans('messages.delete_success_message'));
        }          
             
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
            'inputAttributes' => ['newsId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $newsId = $event['data']['inputAttributes']['newsId'];
        $model = Post::find($newsId);
        $model->update(['status' => !$model->status]);

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal)
    {
        $this->status = (!$statusVal) ? 1 : 0;
    }
}
