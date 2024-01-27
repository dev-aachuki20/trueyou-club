<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class QuoteHistory extends Component
{
    public $userId;

    use WithPagination;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10;

    protected $listeners = [
        'refreshTable' => 'render',
        'updatePaginationLength',
    ];

    public function mount($user_id){
        $this->userId = $user_id;
    }

    public function updatePaginationLength($length)
    {
        $this->resetPage();
        $this->paginationLength = $length;
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
        $searchValue = $this->search;

        $completedQuotes = null;

        // $completedQuotes = User::query()->where(function ($query) use ($searchValue, $statusSearch, $starNumber) {
        //     $query->where('name', 'like', '%' . $searchValue . '%')
        //         ->orWhere('phone', 'like', '%' . $searchValue . '%')
        //         ->orWhere('star_no', $starNumber)
        //         ->orWhere('is_active', $statusSearch)
        //         ->orWhereRaw("date_format(created_at, '" . config('constants.search_full_date_format') . "') like ?", ['%' . $searchValue . '%']);
        //     })
        //     ->whereHas('roles', function ($query) {
        //         $query->where('id', 2);
        //     })
        //     ->orderBy($this->sortColumnName, $this->sortDirection)
        //     ->paginate($this->paginationLength);

        return view('livewire.admin.user.quote-history',compact('completedQuotes'));
    }
}
