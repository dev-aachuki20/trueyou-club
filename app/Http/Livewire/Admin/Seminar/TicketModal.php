<?php

namespace App\Http\Livewire\Admin\Seminar;

use Livewire\Component;

class TicketModal extends Component
{
    // protected $layout = null;

    public $booking_id,$showModal = false;

    public function mount($booking_id){
        $this->booking_id = $booking_id;
    }

    public function render()
    {
        return view('livewire.admin.seminar.ticket-modal');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
