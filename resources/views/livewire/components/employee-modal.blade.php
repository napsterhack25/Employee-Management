<div> <!-- ✅ Root div added -->
    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">{{ $userId ? 'Edit' : 'Add New' }} Employee</h2>

            <form wire:submit.prevent="save">
                <input type="hidden" wire:model="userId">

                <!-- ✅ First Name & Last Name in Single Row -->
                <div class="flex space-x-2">
                    <div class="w-1/2">
                        <label>First Name</label>
                        <input type="text" wire:model="first_name" class="w-full p-2 border rounded mb-2">
                        @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-1/2">
                        <label>Last Name</label>
                        <input type="text" wire:model="last_name" class="w-full p-2 border rounded mb-2">
                        @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>


                <label>Email</label>
                <input type="email" wire:model="email" class="w-full p-2 border rounded mb-2">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label>Phone</label>
                <input type="text" wire:model="phone" class="w-full p-2 border rounded mb-2">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label>Post</label>
                <input type="text" wire:model="post" class="w-full p-2 border rounded mb-2">
                @error('post') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label>Image</label>
                <input type="file" wire:model="image" class="w-full p-2 border rounded mb-2">


                <!-- ✅ Show existing image preview when editing -->
                @if ($image)
                <img src="{{ $image }}" class="w-20 h-20 rounded-full mt-2">
                @endif

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-400 text-white rounded">Close</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ $userId ? 'Update' : 'Add' }} Employee</button>
                </div>
            </form>
        </div>
    </div>
    @endif



</div> <!-- ✅ Closing root div -->