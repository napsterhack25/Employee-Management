<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;



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

        // ✅ Store only filename instead of full URL
        $this->image = $user->image;

        $this->showModal = true;

        Log::info('showModal set to true with image:', ['image' => $this->image]);

        $this->dispatch('refresh');
    }
  
    public function save()
    {
        Log::info('Save method triggered', ['userId' => $this->userId]);
    
        try {
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'phone' => 'required|numeric',
                'post' => 'required|string',
            ];
    
            if ($this->image instanceof TemporaryUploadedFile) {
                $rules['image'] = 'nullable|image|max:1024';
            }
    
            $data = $this->validate($rules);
            $data['name'] = trim($this->first_name . ' ' . $this->last_name);
    
            if (!$this->userId) {
                $data['password'] = Hash::make('default123');
                $message = 'User created successfully!';
            } else {
                unset($data['password']);
                $message = 'User updated successfully!';
            }
    
            if ($this->image instanceof TemporaryUploadedFile) {
                $data['image'] = $this->image->store('users', 'public');
            } else {
                $data['image'] = $this->image;
            }
    
            if ($this->userId) {
                User::findOrFail($this->userId)->update($data);
            } else {
                User::create($data);
            }
    
            $this->resetForm();
            $this->showModal = false;
    
            // ✅ Dispatch event with message
            $this->dispatch('successMessage', $message);
    
            // ✅ Refresh other components if needed
            $this->dispatch('refreshUsers')->to(\App\Livewire\Management::class);
    
        } catch (\Exception $e) {
            Log::error('Error saving user:', ['error' => $e->getMessage()]);
            $this->dispatch('errorMessage', $e->getMessage());
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
