<?php

namespace App\Http\Livewire\Admin\Volunteer;

use App\Models\Event;
use Livewire\Component;

class InviteModal extends Component
{   

    public $showModal = false;
    public $events = [];
    public $event_id = null;
    public $volunteer_id = null;
    public $custom_message = '';

    protected $rules = [
        'event_id' => 'required|exists:events,id',
        'custom_message' => 'required|string|max:255',
    ];

    protected $listeners = ['showInviteModal' => 'show'];

    public function mount()
    {
        $this->events = Event::where('status',1)->get(); // Fetch all events
    }

    public function show($volunteer_id)
    {
        $this->volunteer_id = $volunteer_id;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'event_id','volunteer_id', 'custom_message']); // Reset form fields
        $this->emit('hideInviteModal'); // Optional: Emit event to hide modal
    }

    public function submit()
    {
        $this->validate();

        // Handle form submission logic here
        // Example: Store the data, send notifications, etc.

        $this->closeModal(); // Close modal after submission
    }


    public function render()
    {
        return view('livewire.admin.volunteer.invite-modal');
    }
}
