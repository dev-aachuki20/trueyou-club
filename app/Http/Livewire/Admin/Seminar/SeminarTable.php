<?php

namespace App\Http\Livewire\Admin\Seminar;

use App\Models\Seminar;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeminarDatatableExport; 

class SeminarTable extends Component
{
    use WithPagination;

    protected $layout = null;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10, $searchBoxPlaceholder = "Search By Title, Venue, Date";

    public $filter_date_range, $filterStartDate, $filterEndDate;

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

        $startDate = $this->filterStartDate ? $this->filterStartDate->startOfDay() : null;
        $endDate = $this->filterEndDate ? $this->filterEndDate->endOfDay() : null;
        
        $allSeminar = Seminar::query()->select('*')
        ->selectRaw('(TIMESTAMPDIFF(SECOND, NOW(), CONCAT(start_date, " ", end_time))) AS time_diff_seconds')

        ->where(function ($query) use ($searchValue, $statusSearch) {
            $query->where('title', 'like', '%' . $searchValue . '%')
                ->orWhere('venue', 'like', '%' . $searchValue . '%')
                ->orWhereRaw("DATE_FORMAT(start_date,  '" . config('constants.search_full_date_format') . "') = ?", [date(config('constants.full_date_format'), strtotime($searchValue))]);

            // Check for month name (e.g., January)
            $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);

            // Check for day and month (e.g., 13 January)
            $query->orWhereRaw('LOWER(DATE_FORMAT(start_date, "%e %M")) LIKE ?', ['%' . strtolower($searchValue) . '%']);
        });

        if(!is_null($startDate) && !is_null($endDate)){
            $allSeminar = $allSeminar->whereBetween('start_date', [$startDate, $endDate]);
        }

        $allSeminar = $allSeminar->orderByRaw('
            CASE 
                WHEN CONCAT(start_date, " ", end_time) <= NOW() AND CONCAT(start_date, " ", end_time) >= NOW() THEN 0
                WHEN CONCAT(start_date, " ", end_time) > NOW() THEN 1
                ELSE 2
            END ASC,
            time_diff_seconds > 0 ASC, ABS(time_diff_seconds) ASC
        ');

        // ->orderBy($this->sortColumnName, $this->sortDirection)
        $allSeminar = $allSeminar->paginate($this->paginationLength);

        return view('livewire.admin.seminar.seminar-table', compact('allSeminar'));
    }

    public function submitFilterForm(){
        $rules = [
            'filter_date_range' => 'required',
        ];
        $this->validate($rules,[
            'filter_date_range'=>'Please select date'
        ]);

        $date_range = explode(' - ', $this->filter_date_range);
        $this->filterStartDate = Carbon::parse(date('Y-m-d',strtotime(str_replace(' ','-',$date_range[0]))));
        $this->filterEndDate   = Carbon::parse(date('Y-m-d',strtotime(str_replace(' ','-',$date_range[1]))));
    }

    public function restFilterForm(){
        $this->reset(['filter_date_range','filterStartDate','filterEndDate']);
        $this->resetValidation();
        $this->initializePlugins();
    }

    public function exportToExcel()
    {
        return Excel::download(new SeminarDatatableExport($this->filterStartDate,$this->filterEndDate,$this->search,$this->sortColumnName,$this->sortDirection), 'seminar-list.xlsx');
    }

    public function initializePlugins()
    {
        $this->dispatchBrowserEvent('loadPlugins');
    }
}
