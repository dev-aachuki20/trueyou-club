<?php

namespace App\Http\Livewire\Admin\Contact;

use Gate;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Contact;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\ContactReplyNotification;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    use  LivewireAlert, WithFileUploads;

    public $search = '', $formMode = false, $updateMode = false, $viewMode = false;

    public $contact_id = null, $first_name,  $last_name, $phone_number, $email, $message, $status = 1;

    public $fullname, $reply, $reply_id;

    protected $listeners = [
        'cancel', 'show', 'edit', 'toggle', 'confirmedToggleAction', 'delete', 'deleteConfirm', 'reply'
    ];


    public function mount()
    {
        abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }


    public function render()
    {
        return view('livewire.admin.contact.index');
    }

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
        $this->initializePlugins();
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

    public function reply($id)
    {
        $getContactDetail = Contact::where('id', $id)->first();
        $this->fullname     = $getContactDetail->first_name . ' ' . $getContactDetail->last_name;
        // $this->first_name   = $getContactDetail->first_name;
        // $this->last_name    = $getContactDetail->last_name;
        $this->email        = $getContactDetail->email;
        $this->reply_id     = $getContactDetail->id;
        $this->reply        = $getContactDetail->reply;

        $this->formMode     = true;
        $this->updateMode   = true;
    }

    public function draftReply($draft_id)
    {
        $draftDetail = Contact::find($draft_id);

        $draftDetail->update(['is_draft' => 1, 'reply' => $this->reply]);

        $this->alert('success', trans('messages.message_in_draft'));
    }

    public function sendReply($id)
    {
        $detail = Contact::find($id);

        $detail->update(['is_draft' => 0, 'reply' => $this->reply]);

        // Send email notification
        $name     = $detail->first_name . ' ' . $detail->last_name;
        $subject  = 'Assistance with Your Inquiry';
        $reply    = $detail->reply;

        Mail::to($detail->email)->send(new ContactReplyNotification($name, $subject, $reply));

        $this->alert('success', trans('messages.mail_sent'));

        return redirect()->to('/admin/contacts');
    }


   
}
