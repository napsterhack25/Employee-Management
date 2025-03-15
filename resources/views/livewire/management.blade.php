<div> <!-- ✅ Added root <div> -->
    <div class="p-6">
        <div class="flex justify-between mb-4 bg-red-500 p-4 rounded">
            <h2 class="text-3xl font-extrabold text-white">Manage Employees</h2>

            <button class="bg-white text-black px-4 py-2 rounded border border-black" wire:click="$dispatch('openEmployeeModal')">
                + Add New Employee
            </button>

        </div>

        <div class="mb-4 flex justify-between items-center">
            <!-- 🔹 Left Side: Show Entries Dropdown -->
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-700">Show</label>
                <select wire:model.lazy="perPage" class="border p-2 rounded">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <label class="text-sm text-gray-700">entries</label>
            </div>

            <div class="ml-auto">
            <input type="text" wire:model="search" wire:keydown="updateSearch" class="border p-2 rounded w-64" placeholder="Search employees...">
            </div>
        </div>






        <table class="min-w-full bg-white border rounded shadow-md">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2 cursor-pointer" wire:click="sortBy('id')">
                        ID
                        <span>{!! $sortField === 'id' ? ($sortDirection === 'asc' ? '↑' : '↓') : '⇅' !!}</span>
                    </th>
                    <th class="p-2">Image</th>
                    <th class="p-2 cursor-pointer" wire:click="sortBy('name')">
                        Name
                        <span>{!! $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '⇅' !!}</span>
                    </th>
                    <th class="p-2 cursor-pointer" wire:click="sortBy('email')">
                        Email
                        <span>{!! $sortField === 'email' ? ($sortDirection === 'asc' ? '↑' : '↓') : '⇅' !!}</span>
                    </th>
                    <th class="p-2 cursor-pointer" wire:click="sortBy('post')">
                        Post
                        <span>{!! $sortField === 'post' ? ($sortDirection === 'asc' ? '↑' : '↓') : '⇅' !!}</span>
                    </th>
                    <th class="p-2 cursor-pointer" wire:click="sortBy('phone')">
                        Phone
                        <span>{!! $sortField === 'phone' ? ($sortDirection === 'asc' ? '↑' : '↓') : '⇅' !!}</span>
                    </th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>



            <tbody>
                @forelse ($users as $user)
                <tr class="border-t">
                    <td class="p-2">{{ $user->id }}</td>
                    <td class="p-2">
                        <img src="{{ asset('storage/' . $user->image) }}" class="w-12 h-12 rounded-full" alt="User Image">
                    </td>
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2">{{ $user->post }}</td>
                    <td class="p-2">{{ $user->phone }}</td>
                    <td class="p-2">
                        <button wire:click="$dispatch('editEmployee', { id: {{ $user->id }} })">
                            <i class="fas fa-edit text-green-500 hover:text-yellow-700 text-lg"></i>
                        </button>

                        <button @click="$dispatch('confirmDelete', { userId: {{ $user->id }} })">
                            <i class="fas fa-trash text-red-500 hover:text-red-700 text-lg"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">No results found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



        <livewire:components.employee-modal />

        <livewire:components.delete-confirmation />

        <div class="mt-4 flex justify-between items-center">
            <!-- 🔹 Pagination Info (Left) -->
            <div class="text-sm text-gray-700">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </div>

            <div class="flex space-x-2">
                @if ($users->onFirstPage())
                <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed">Previous</span>
                @else
                <button wire:click="previousPage" class="px-4 py-2 bg-blue-500 text-white rounded">Previous</button>
                @endif


                @if ($users->hasMorePages())
                <button wire:click="nextPage" class="px-4 py-2 bg-blue-500 text-white rounded">Next</button>
                @else
                <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>


    </div>

    @if (session()->has('error'))
    <div class="p-2 bg-red-100 text-red-600 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if (session()->has('success'))
    <div class="p-2 bg-green-100 text-green-600 rounded">
        {{ session('success') }}
    </div>
    @endif

</div> <!-- ✅ Closing root <div> -->