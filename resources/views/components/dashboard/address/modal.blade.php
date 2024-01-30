<div x-data="{ showModal: false }">
    <!-- Your DataTable code here -->

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <!-- Modal content goes here -->
                <!-- You can use Livewire or other methods to load the content here -->
            </div>
            <div class="modal-footer py-4">
                <button @click="showModal = false" class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
            </div>
        </div>
    </div>
</div>
