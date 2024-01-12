<?php

namespace App\Http\Livewire\Admin\Contact;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class ContactTable extends Component
{
    use WithPagination;

    public $search = null;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10;
    public $sortColumnFullName = 'full_name';

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

    public function sortByName($column)
    {
        if ($this->sortColumnFullName === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumnFullName = $column;
            $this->sortDirection = 'asc';
        }
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

        $allContacts = Contact::query()->where(function ($query) use ($searchValue, $statusSearch) {
            $query
                ->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $searchValue . '%'])
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('phone_number', 'like', '%' . $searchValue . '%')
                ->orWhere('status', $statusSearch)
                ->orWhereRaw("date_format(created_at, '" . config('constants.search_datetime_format') . "') like ?", ['%' . $searchValue . '%']);
        })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationLength);

        return view('livewire.admin.contact.contact-table', compact('allContacts'));
    }
}
