<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;

    protected $layout = null;
    
    public function mount(){
       
    }
    
    public function render()
    {
        return view('livewire.admin.index');
    }

}
