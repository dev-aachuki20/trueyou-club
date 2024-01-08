<?php

namespace App\Http\Livewire\Admin\Health;

use App\Models\Health;
use Livewire\Component;

class Show extends Component
{
    protected $layout = null;

    public $detail;

    public function mount($health_id)
    {
        $this->detail = Health::find($health_id);
    }
    public function render()
    {
        return view('livewire.admin.health.show');
    }
    public function cancel()
    {
        $this->emitUp('cancel');
    }
}
