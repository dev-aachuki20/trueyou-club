<?php

namespace App\Http\Livewire\Admin\Webinar;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Webinar;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class WebinarTable extends Component
{
    use WithPagination;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'asc', $paginationLength = 10, $searchBoxPlaceholder = "Search By Title, Date";

    protected $listeners = [
        'refreshTable' => 'render',
    ];

    public function updatedPaginationLength()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($columnName)
    {
        $this->resetPage();

        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        $statusSearch = null;
        $searchValue = $this->search;
        // if (Str::contains('active', strtolower($searchValue))) {
        //     $statusSearch = 1;
        // } else if (Str::contains('inactive', strtolower($searchValue))) {
        //     $statusSearch = 0;
        // }

      
        $allWebinar = Webinar::query()
        ->select('*')->selectRaw('(TIMESTAMPDIFF(SECOND, NOW(), CONCAT(start_date, " ", end_time))) AS time_diff_seconds')
        ->where(function ($query) use ($searchValue, $statusSearch) {

            $query->where('title', 'like', '%' . $searchValue . '%')
                ->orWhereRaw("DATE_FORMAT(start_date,  '" . config('constants.search_full_date_format') . "') = ?", [date(config('constants.full_date_format'), strtotime($searchValue))]);

            // Check for month name (e.g., January)
            $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);

            // Check for day and month (e.g., 13 January)
            $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%e %M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);
        })

        ->orderByRaw('CASE WHEN CONCAT(start_date, " ", end_time) < NOW() THEN 1 ELSE 0 END') 
        ->orderBy(\DB::raw('time_diff_seconds > 0 DESC, ABS(time_diff_seconds)'), 'asc')

            // ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationLength);


        // $allWebinar = Webinar::query()
        // ->select('*', DB::raw('
        //     CASE
        //         WHEN start_date > CURRENT_DATE OR (start_date = CURRENT_DATE AND start_time > CURRENT_TIME) THEN "upcoming"
        //         WHEN start_date = CURRENT_DATE AND start_time <= CURRENT_TIME AND end_time >= CURRENT_TIME THEN "ongoing"
        //         ELSE "expired"
        //     END AS status'))
        // ->where(function ($query) use ($searchValue, $statusSearch) {

        //     $query->where('title', 'like', '%' . $searchValue . '%')
        //         ->orWhereRaw("DATE_FORMAT(start_date,  '" . config('constants.search_full_date_format') . "') = ?", [date(config('constants.full_date_format'), strtotime($searchValue))]);

        //     // Check for month name (e.g., January)
        //     $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);

        //     // Check for day and month (e.g., 13 January)
        //     $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%e %M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);
        // })
        // ->orderBy(DB::raw('
        //     CASE
        //         WHEN start_date = CURRENT_DATE AND end_time <= CURRENT_TIME AND end_time >= CURRENT_TIME THEN 1
        //         WHEN start_date > CURRENT_DATE OR (start_date = CURRENT_DATE AND start_time > CURRENT_TIME) THEN 2
        //         ELSE 3
        //     END'))
        // ->orderBy(DB::raw('
        // CASE
        //     WHEN start_date <= CURRENT_DATE AND start_time < CURRENT_TIME THEN 4
        //     ELSE 5
        // END'))
        // ->when('expired', function ($query) {
        //     $query->orderBy('start_date', 'desc')->orderBy('start_time', 'desc');
        // })
        // ->orderBy('start_date')
        // ->orderBy('start_time')
        // // ->orderBy($this->sortColumnName, $this->sortDirection)
        // ->paginate($this->paginationLength);

        return view('livewire.admin.webinar.webinar-table', compact('allWebinar'));
    }

}
