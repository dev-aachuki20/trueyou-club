<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;


class Show extends Component
{
   
    protected $layout = null;
    
    public $detail;

    public function mount($blog_id){
        $this->detail = Blog::find($blog_id);
    }
   
    public function render()
    {
        return view('livewire.admin.blog.show');
    }

    public function cancel(){
        $this->emitUp('cancel');
    }
}
