<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Str;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads, WithPagination;

    public $search = null, $formMode = false, $updateMode = false, $viewMode = false;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10, $searchBoxPlaceholder = "Search By Name, Created Date";

    public $category_id = null, $name,$created_at, $status = 1;   
    
    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm'
    ];

    public function mount()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->created_at = Carbon::now()->format('d-m-Y');
    }

    public function updatedPaginationLength()
    {
        $this->resetPage();
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        $statusSearch = null;
        $searchValue = $this->search;
        if (Str::contains('active', strtolower($searchValue))) {
            $statusSearch = 1;
        } else if (Str::contains('inactive', strtolower($searchValue))) {
            $statusSearch = 0;
        }

        $currentDate = now()->format('Y-m-d');

        $allCategory = Category::query()->where(function ($query) use ($searchValue, $statusSearch) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                // ->orWhere('status', $statusSearch)
                ->orWhereRaw("date_format(created_at, '" . config('constants.search_full_date_format') . "') like ?", ['%' . $searchValue . '%']);
        })
            
            ->orderByRaw('CASE 
                    WHEN created_at >= "'.$currentDate.'" THEN 0
                    WHEN created_at <= "'.$currentDate.'" THEN 1
                    ELSE 3
                END,
                created_at'
            )

            ->paginate($this->paginationLength);


        return view('livewire.admin.category.index',compact('allCategory'));
    }   

    public function create()
    {
        $this->initializePlugins();
        $this->formMode = true;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name'        => 'required',           
            'status'       => 'required',
        ]);

        DB::beginTransaction();
        try {

            $validatedData['status'] = $this->status;
            $category = Category::create($validatedData);           

            DB::commit();

            $this->resetAllFields();

            $this->flash('success', trans('messages.add_success_message'));

            return redirect()->route('admin.categories');
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

        $category = Category::findOrFail($id);
        $this->category_id         =  $category->id;
        $this->name           =  $category->name;
        $this->status          =  $category->status;       
    }


    public function update()
    {
        $validatedData = $this->validate([
            'name'        => 'required',         
        ]);
        
        $validatedData['status'] = $this->status;        

        DB::beginTransaction();
        try {

            $category = Category::find($this->category_id);         

            $category->update($validatedData);

            DB::commit();

            // $this->flash('success', trans('messages.edit_success_message'));

            $this->alert('success', trans('messages.edit_success_message'));

            $this->cancel();

            // return redirect()->route('admin.categories');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', trans('messages.error_message'));
        }
    }

    public function show($id)
    {
        $this->category_id = $id;
        $this->formMode = false;
        $this->viewMode = true;
    }

    public function initializePlugins()
    {
        $this->dispatchBrowserEvent('loadPlugins');
    }

    public function cancel()
    {
        $this->resetAllFields();
        $this->resetValidation();
    }

    public function resetAllFields(){
        $this->reset(['formMode','updateMode','viewMode','category_id','name','status']);
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
        $model    = Category::find($deleteId);
        
        if(!$model){
            // $this->emit('refreshTable'); 
            $this->alert('error', trans('messages.error_message'));   
        }else{
            $model->delete();

            $this->resetPage();
            
            // $this->emit('refreshTable');    
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
            'inputAttributes' => ['categoryId' => $id],
        ]);
    }

    public function confirmedToggleAction($event)
    {
        $categoryId = $event['data']['inputAttributes']['categoryId'];
        $model = Category::find($categoryId);
        $model->update(['status' => !$model->status]);

        // $this->emit('refreshTable');

        $this->alert('success', trans('messages.change_status_success_message'));
    }

    public function changeStatus($statusVal)
    {
        $this->status = (!$statusVal) ? 1 : 0;
    }
}
