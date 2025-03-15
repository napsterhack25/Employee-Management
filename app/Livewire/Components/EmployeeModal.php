<?php

namespace App\Livewire\Components; 

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash; 



class EmployeeModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $userId, $first_name, $last_name, $email, $phone, $post, $image; 
    protected $listeners = ['openEmployeeModal' => 'open', 'editEmployee' => 'edit'];

    public function open()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        Log::info('Edit event received with ID:', ['id' => $id]);

        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->first_name = explode(' ', $user->name)[0] ?? '';
        $this->last_name = explode(' ', $user->name)[1] ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->post = $user->post;

        // ✅ Load existing image path
        $this->image = $user->image ? asset('storage/' . $user->image) : null;

        $this->showModal = true;

        Log::info('showModal set to true with image:', ['image' => $this->image]);

        $this->dispatch('refresh');
    }



    public function save()
    {
        Log::info('Save method triggered');

        $data = $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'phone' => 'required|numeric',
            'post' => 'required|string',
            'image' => 'nullable|image|max:1024',
        ]);

        $data['name'] = trim($this->first_name . ' ' . $this->last_name);

        if (!$this->userId) {
            $data['password'] = Hash::make('default123');
        } else {
            unset($data['password']);
        }

        if ($this->image) {
            $data['image'] = $this->image->store('users', 'public');
        }

        try {
            if ($this->userId) {
                User::findOrFail($this->userId)->update($data);
                Log::info('User Updated: ' . $this->userId);
            } else {
                $user = User::create($data);
                Log::info('New User Created: ' . $user->id);
            }
            $this->resetForm();
            $this->showModal = false;
            $this->dispatch('refreshUsers')->to(\App\Livewire\Management::class);
            $this->emit('$refresh');
            session()->flash('success', 'User saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving user:', ['error' => $e->getMessage()]);
            session()->flash('error', $e->getMessage());
        }
    }


    private function resetForm()
    {
        $this->userId = null;
        $this->first_name = ''; 
        $this->last_name = ''; 
        $this->email = '';
        $this->phone = '';
        $this->post = '';
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.components.employee-modal');
    }
}
