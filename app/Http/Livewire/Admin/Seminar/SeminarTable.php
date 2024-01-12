<?php

namespace App\Http\Livewire\Admin\Seminar;

use App\Models\Seminar;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class SeminarTable extends Component
{
    use WithPagination;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10, $searchBoxPlaceholder="Search By Title, Venue, Date";

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

        $allSeminar = Seminar::query()->where(function ($query) use ($searchValue, $statusSearch) {
            $query->where('title', 'like', '%' . $searchValue . '%')
            ->orWhere('venue', 'like', '%' . $searchValue . '%')
            ->orWhereRaw("DATE_FORMAT(start_date,  '" . config('constants.search_full_date_format') . "') = ?", [date(config('constants.full_date_format'), strtotime($searchValue))]);
            // ->orWhereRaw("DATE_FORMAT(start_time,  '" . config('constants.search_full_time_format') . "') = ?", [date(config('constants.full_time_format'), strtotime($searchValue))])
            // ->orWhereRaw("DATE_FORMAT(end_time,  '" . config('constants.search_full_time_format') . "') = ?", [date(config('constants.full_time_format'), strtotime($searchValue))]);
               
        })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationLength);
        return view('livewire.admin.seminar.seminar-table', compact('allSeminar'));
    }
}
