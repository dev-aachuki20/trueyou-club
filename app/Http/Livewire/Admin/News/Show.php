<?php

namespace App\Http\Livewire\Admin\News;

use Livewire\Component;
use App\Models\News;

class Show extends Component
{
    protected $layout = null;
    
    public $detail;

    public function mount($news_id){
        $this->detail = News::find($news_id);
    }
   
    public function render()
    {
        return view('livewire.admin.news.show');
    }

    public function cancel(){
        $this->emitUp('cancel');
    }
}
