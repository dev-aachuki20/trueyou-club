<?php

namespace App\Http\Livewire\Admin;

use App\Models\Quote;
use App\Models\Seminar;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Webinar;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;

    protected $layout = null;

    public function mount()
    {
    }

    public function render()
    {
        $currentDate = now()->toDateString();
        $currentTime = now()->toTimeString();

        $webinar = Webinar::query()
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('start_date', '=', $currentDate)
                    ->where('start_time', '<=', $currentTime)
                    ->where('end_time', '>', $currentTime);
            })
            ->orWhere(function ($query) use ($currentDate) {
                $query->where('start_date', '>', $currentDate);
            })
            ->orWhere(function ($query) use ($currentDate, $currentTime) {
                $query->where('start_date', '<=', $currentDate);
                $query->where('end_time', '<=', $currentTime);
            })

            // ->orderBy('start_date')
            // ->orderBy('start_time')
            ->first();

        $seminar = Seminar::query()
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('start_date', '=', $currentDate)
                    ->where('start_time', '<=', $currentTime)
                    ->where('end_time', '>', $currentTime);
            })
            ->orWhere(function ($query) use ($currentDate) {
                $query->where('start_date', '>', $currentDate);
            })
            ->orWhere(function ($query) use ($currentDate, $currentTime) {
                $query->where('start_date', '<=', $currentDate);
                $query->where('end_time', '<=', $currentTime);
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->first();

        $todaysQuote = Quote::whereDate('created_at', today())->first();

        return view('livewire.admin.index', compact('webinar', 'seminar', 'todaysQuote'));
    }
}
