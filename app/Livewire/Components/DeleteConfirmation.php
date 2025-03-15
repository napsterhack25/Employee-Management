<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\User;

class DeleteConfirmation extends Component
{
    public $userId;
    public $showModal = false;

    protected $listeners = ['confirmDelete' => 'openDeleteModal'];

    public function openDeleteModal($userId)
    {
        $this->userId = $userId; 
        $this->showModal = true;
    }


    public function deleteUser()
    {
        if ($this->userId) {
            User::find($this->userId)?->delete();
            $this->dispatch('refreshUsers');
            $this->showModal = false;
        }
    }

    public function render()
    {
        return view('livewire.components.delete-confirmation');
    }
}
