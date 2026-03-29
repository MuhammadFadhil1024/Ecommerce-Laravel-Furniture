<div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden modal" id="categoryModal">
    <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-75" />
        </div>
        <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline" id="dataAddress">
            <form id="categoryForm">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <input type="hidden" id="categoryId" name="categoryId">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" required>
                    </div>
                    <div class="mb-4">
                        <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail URL:</label>
                        <input type="file"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="thumbnail" name="thumbnail" required>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" id="saveBtn"
                        onclick="saveCategory()">Save</button>
                </div>
            </form>
            <div class="bg-gray-200 px-4 py-3 text-right">
                <button type="button" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-700 mr-2"
                    onclick="toggleModal()">Close</button>
            </div>
        </div>
    </div>
</div>
