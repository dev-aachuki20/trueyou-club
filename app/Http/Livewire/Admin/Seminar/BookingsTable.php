<?php

namespace App\Http\Livewire\Admin\Seminar;

use App\Models\Seminar;
use Livewire\Component;
use Livewire\WithPagination;

class BookingsTable extends Component
{
    use WithPagination;

    protected $layout = null;

    public $search = null;

    public $seminarId;

    public $sortColumnName = 'created_at', $sortDirection = 'desc', $paginationLength = 10, $searchBoxPlaceholder = "Search By User Name, Booking Number, Created";

    protected $listeners = [
        'refreshTable' => 'render',
        'updatePaginationLength',
        'show'
    ];

    public function mount($seminar_id){
        $this->seminarId = $seminar_id;
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
        
        $seminar = Seminar::find($this->seminarId);
        $seminarName = $seminar->title;
        $seminarBookings = $seminar->bookings()->where(function ($query) use ($searchValue) {
            $query
                /* ->whereHas('user', function($q) use($searchValue){
                    $q->where('name', 'like', '%' . $searchValue . '%');
                }) */
                // ->whereJsonContains('user_details->name', '%'.$searchValue.'%')
                ->orWhere('booking_number', 'like', '%' . $searchValue . '%')
                ->orWhereRaw("date_format(created_at, '" . config('constants.search_full_date_format') . "') like ?", ['%' . $searchValue . '%']);
        })
        ->orderBy($this->sortColumnName, $this->sortDirection)
        ->paginate($this->paginationLength);

        return view('livewire.admin.seminar.bookings-table', compact('seminarBookings', 'seminarName'));
    }

    public function cancel(){
        $this->emitUp('cancel');
    }
}
