<?php

namespace App\Http\Livewire\Admin\Health;

use App\Models\Health;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;


class HealthTable extends Component
{
    use WithPagination;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10;

    protected $listeners = [
        'refreshTable' => 'render',
        'updatePaginationLength',
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
        if (Str::contains('active', strtolower($searchValue))) {
            $statusSearch = 1;
        } else if (Str::contains('inactive', strtolower($searchValue))) {
            $statusSearch = 0;
        }

        $allHealth = Health::query()->where(function ($query) use ($searchValue, $statusSearch) {
            $query->where('title', 'like', '%' . $searchValue . '%')
                ->orWhere('status', $statusSearch)
                ->orWhereRaw("date_format(publish_date, '" . config('constants.search_datetime_format') . "') like ?", ['%' . $searchValue . '%'])
                ->orWhereRaw("date_format(created_at, '" . config('constants.search_datetime_format') . "') like ?", ['%' . $searchValue . '%']);
        })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationLength);
        return view('livewire.admin.health.health-table', compact('allHealth'));
    }
}