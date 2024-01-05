<?php

namespace App\Http\Livewire\Admin\Quote;

use Gate;
use Livewire\Component;
use App\Models\Quote;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    protected $layout = null;

    public $search = '', $formMode = false , $updateMode = false, $quote='', $viewMode = false, $modalType = '', $todayDateExist='';

    public $quote_id=null, $message;

    public $removeImage = false;

    protected $listeners = [
        'cancel','show', 'edit', 'toggle', 'updateStatus', 'confirmedToggleAction','delete','deleteConfirm'
    ];

    public function mount(){
        abort_if(Gate::denies('quote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function render()
    {
        $this->todayDateExist = Quote::whereDate('created_at', Carbon::today())->where('created_by', auth()->user()->id)->exists();
        return view('livewire.admin.quote.index');
    }

    public function create()
    {
        if($this->todayDateExist){
            $this->flash('error',trans('Today quoate is already created'));
            return redirect()->route('admin.quotes');
        }

        $this->initializePlugins();
        // $this->formMode = true;
        $this->modalType = 'Add';

        $this->dispatchBrowserEvent('openModal');
    }

    public function store(){
        $validatedData = $this->validate([
            'message'        => 'required',
        ]);

        Quote::create($validatedData);

        $this->reset(['message']);

        $this->initializePlugins();

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.add_success_message'));
    }

    public function edit($id)
    {
        $this->initializePlugins();
        $this->dispatchBrowserEvent('openModal');
        // $this->formMode = true;
        $this->updateMode = true;
        $this->modalType = 'Edit';


        $quote = Quote::findOrFail($id);
        $this->quote_id      =  $quote->id;
        $this->message           =  $quote->message;
    }


    public function update(){
        $validatedArray['message']        = 'required';
        $validatedData = $this->validate($validatedArray);

        $quote = Quote::find($this->quote_id);

        $quote->update($validatedData);

        $this->reset(['message']);

        $this->initializePlugins();

        $this->emit('refreshTable');

        $this->alert('success',trans('messages.edit_success_message'));
    }

    public function show($id){
        $this->quote = Quote::findOrFail($id);
        $this->modalType = 'View';
        $this->dispatchBrowserEvent('openModal');
    }

    public function initializePlugins(){
        $this->dispatchBrowserEvent('loadPlugins');
    }

    public function cancel(){
        $this->modalType = '';
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('loadPlugins');
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
        $model    = Quote::find($deleteId);
        $model->delete();

        $this->emit('refreshTable');

        $this->alert('success', trans('messages.delete_success_message'));
    }
}
