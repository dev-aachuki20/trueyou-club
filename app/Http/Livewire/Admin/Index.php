<?php

namespace App\Http\Livewire\Admin;

use App\Models\Quote;
use App\Models\Role;
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

        /* $webinar = Webinar::query()
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
            ->first(); */
        $webinar = Webinar::query()
        ->select('*')->selectRaw('(TIMESTAMPDIFF(SECOND, NOW(), CONCAT(start_date, " ", end_time))) AS time_diff_seconds')
        ->orderByRaw('CASE WHEN CONCAT(start_date, " ", end_time) < NOW() THEN 1 ELSE 0 END') 
        ->orderBy(\DB::raw('time_diff_seconds > 0 DESC, ABS(time_diff_seconds)'), 'asc')
        ->first();



        /* $seminar = Seminar::query()
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
            ->first(); */

        $seminar = Seminar::query()
        ->select('*')->selectRaw('(TIMESTAMPDIFF(SECOND, NOW(), CONCAT(start_date, " ", end_time))) AS time_diff_seconds')
        ->orderByRaw('CASE WHEN CONCAT(start_date, " ", end_time) < NOW() THEN 1 ELSE 0 END') 
        ->orderBy(\DB::raw('time_diff_seconds > 0 DESC, ABS(time_diff_seconds)'), 'asc')
        ->first();


        $today = Carbon::today();
        $todaysQuote = Quote::whereDate('created_at', $today)->first();
        $submissionPercentage = 0;
        $leadUsersList = null;
        if ($todaysQuote) {
            $submissionPercentage = $todaysQuote->users()->count() / $this->getTotalUsers() * 100;
            $leadUsersList = $todaysQuote->users;
        }

        return view('livewire.admin.index', compact('webinar', 'seminar', 'todaysQuote', 'submissionPercentage', 'leadUsersList'));
    }

    protected function getTotalUsers()
    {
        // get the total count of users
        $role = Role::where('title', 'User')->first();
        return $role ? $role->users()->count() : 0;
    }
}
