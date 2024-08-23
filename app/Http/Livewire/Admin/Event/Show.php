<?php

namespace App\Http\Livewire\Admin\Event;

use Livewire\Component;
use App\Models\EventRequest;


class Show extends Component
{
    
    protected $layout = null;

    public $detail;

    public function mount($event_id)
    {
        $this->detail = EventRequest::where($event_id)->get();
    }

    public function render()
    {
        return view('livewire.admin.event.show');
    }

    public function cancel()
    {
        $this->emitUp('cancel');
    }
}
