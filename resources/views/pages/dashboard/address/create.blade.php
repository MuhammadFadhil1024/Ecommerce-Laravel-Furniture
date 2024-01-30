<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; Create
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong !
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>
                            <ul>
                                @foreach ($errors->all() as $eror)
                                    <li>{{ $eror }}</li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    </div>
                @endif
                <form action="{{ route('dashboard.my-address.store') }}" method="post" class="w-full"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Full
                                name</label>
                            <input type="text" value="{{ old('full_name') }}" name="full_name"
                                placeholder="Full Name"
                                class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-text focus:ooutline-none focus:bg-white focus:border-gray-500">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Phone
                                number</label>
                            <input type="number" value="{{ old('telphone_number') }}" name="telphone_number"
                                placeholder="Phone Number"
                                class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-text focus:ooutline-none focus:bg-white focus:border-gray-500">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Place</label>
                            <select name="type_of_place"
                                class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-text focus:ooutline-none focus:bg-white focus:border-gray-500">
                                <option value="">Select place</option>
                                <option value="0">Home</option>
                                <option value="1">Office</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Detail
                                addres</label>
                            <textarea name="detail_address"
                                class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-text focus:ooutline-none focus:bg-white focus:border-gray-500"> {!! old('detail_address') !!} </textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Location</label>
                            <input type="text" id="searchLocation"
                                class="block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 leading-text focus:ooutline-none focus:bg-white focus:border-gray-500 result">
                            <section id="searchResults">
                            </section>
                            <input type="hidden" id="city_id" name="city_id">
                            <input type="hidden" id="province_id" name="province_id">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Save Address
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Event listener for handling click on search results
        $('#searchResults').on('click', '.search-result', function() {
            const selectedResult = $(this).text(); // Get the text from the selected search result
            const cityId = $(this).attr('city-id'); // Get the city-id attribute
            const provinceId = $(this).attr('province-id'); // Get the province-id attribute

            $('#searchLocation').val(selectedResult); // Insert the search result into the input field
            $('#city_id').val(cityId); // Insert the search result into the input field city
            $('#province_id').val(provinceId); // Insert the search result into the input field province
            $('#searchResults').empty(); // Clear the search results
        });

        $('#searchLocation').on('keyup', function() {
            // Get the search query from the input
            const searchQuery = $(this).val().toLowerCase();

            // array data city and province from create method addresscontroller
            const results = @json($cities);

            // Create an empty HTML view
            let htmlView = '';

            //check input searc null or not null
            if (searchQuery.trim() !== '') {
                // Loop through the results and filter based on the search query
                for (const result of results) {
                    if (result.city.toLowerCase().includes(searchQuery)) {
                        // display result result from filter
                        htmlView +=
                            `<div class="block w-full py-3 px-3 bg-gray-200 text-gray-700 search-result mt-1 search-result" province-id="${result['province_id']}" city-id="${result['city_id']}">${result['city']}, ${result['province']}</div>`;
                    }
                }
            }

            // Display the search results in the section element
            $('#searchResults').html(htmlView);
        });
    </script>
</x-app-layout>
