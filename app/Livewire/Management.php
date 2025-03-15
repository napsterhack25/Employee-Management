<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Management extends Component
{
    use WithPagination;

    public $search = ''; // ✅ Search input field
    public $perPage = 5; // ✅ Default pagination
    public $sortField = 'id'; // ✅ Default sorting
    public $sortDirection = 'asc'; // ✅ Sorting direction

    protected $queryString = ['search']; // ✅ Keeps search term in URL

    protected $listeners = ['refreshUsers' => 'refreshList'];

    public function refreshList()
    {
        Log::info('refreshList method called');
        $this->resetPage();
    }

    public function updateSearch()
    {
        $this->resetPage(); 
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteUser($userId)
    {
        User::find($userId)?->delete();
        $this->dispatch('refreshUsers');
    }

    public function render()
    {
        Log::info('Livewire Render Triggered: Search - ' . $this->search);

        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('post', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.management', compact('users'));
    }
}
