<div>
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                
                <!-- 🔥 Exclamation Icon -->
                <div class="flex justify-center mb-3">
                    <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1"></circle>
                        <line x1="12" y1="4" x2="12" y2="12" stroke="currentColor" stroke-width="1"></line>
                        <line x1="12" y1="14" x2="12" y2="16" stroke="currentColor" stroke-width="1"></line>
                    </svg>
                </div>

                <h2 class="text-xl font-bold mb-2 text-center text-gray-800">Are you sure?</h2>
                <p class="text-gray-600 text-center">You won't be able to revert this!</p>

                <div class="flex justify-center space-x-4 mt-4">
                    <button wire:click="deleteUser" class="px-4 py-2 bg-blue-500 text-white rounded">Yes, delete it!</button>
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-red-400 text-white rounded">Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
