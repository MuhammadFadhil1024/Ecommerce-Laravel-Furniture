<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Address') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        {{-- <script>
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                    // url yang sedang dibuka sekarang
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '5%'
                    },
                    {
                        data: 'full_name',
                        name: 'name'
                    },
                    {
                        data: 'telphone_number',
                        name: 'contact'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        ordertable: false,
                        searchable: false,
                    }
                ]

            })
        </script> --}}
        <script>
            function resetModalValues() {
                // Reset all modal values to their initial state or empty values
                $('.name').text('');
                $('.phone').text('');
                $('.place').text('');
                $('.address').text('');
                $('.province').text('');
                $('.city').text('');
            }

            function toggleModal() {
                document.getElementById('showData').classList.toggle('hidden')
                resetModalValues();
            }

            $('#showData').on('hidden.bs.modal', function(e) {
                resetModalValues();
            });

            $('body').on('click', '.showAddress', function() {
                var id = $(this).data('id');
                console.log(id);
                $.get("/dashboard/my-address" + '/' + id, function(data) {
                    // console.log(data);
                    $('.name').text(data.full_name);
                    $('.phone').text(data.telphone_number);
                    switch (data.type_of_place) {
                        case 0:
                            $('.place').text('Home')
                            break;
                        default:
                            $('.place').text('Office')
                            break;
                    }
                    $('.address').text(data.detail_address)
                    $('.province').text(data.province)
                    $('.city').text(data.city)
                })
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.my-address.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Add New Address
                </a>
            </div>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    {{-- <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Contact</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table> --}}
                    @foreach ($addresess as $address)
                        <div class="flex flex-start items-center">
                            <div class="mr-2 text-lg font-semibold">
                                {{ $address->full_name }}
                            </div>
                            <div>
                                -
                            </div>
                            <div class="ml-2 text-sm">
                                {{ $address->telphone_number }}
                            </div>
                        </div>
                        <div class="text-sm mt-1 md:w-1/2">
                            <p>
                                {!! $address->detail_address !!}
                            </p>
                        </div>


                        <div class="flex mt-2">
                            @if ($address->is_active == 1)
                                <div class="px-2 py-1 border-2 mr-1 border-red-400">
                                    Utama
                                </div>
                            @elseif ($address->is_active == 0)
                                <form action="/dashboard/my-address/activate/{{ $address->id }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button class="px-2 py-1 border-2 border-gray-900">
                                        Atur sebagai utama
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('dashboard.my-address.edit', $address->id) }}"
                                class="bg-gray-500 text-white px-2 py-1 ml-2">
                                Edit
                            </a>
                            <button onclick="toggleModal()" data-id="{{ $address->id }}"
                                class="bg-yellow-500 text-white px-2 py-1 ml-2 showAddress">
                                Detail
                            </button>
                        </div>
                        <div class="border-b-2 border-gray-200 my-4"></div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <div class="modal"> --}}
        <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden modal" id="showData">
            <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-900 opacity-75" />
                </div>
                {{-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span> --}}
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline" id="dataAddress">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full">
                                <label class="font-bold text-base">Name</label>
                                <div class="w-full border-b-2 font-medium text-lg name">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full">
                                <label class="font-bold text-base">Phone Number</label>
                                <div class="w-full border-b-2 font-medium text-lg phone">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full">
                                <label class="font-bold text-base">Address labels</label>
                                <div class="w-full border-b-2 font-medium text-lg place">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full">
                                <label class="font-bold text-base">Detail address</label>
                                <div class="w-full border-b-2 font-medium text-lg address">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-6">
                            <div class="w-full">
                                <label class="font-bold text-base">Location</label>
                                <div class="w-full flex border-b-2 font-medium text-lg">
                                    <p class="city mr-2"></p>
                                    <p class="province"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-200 px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-700 mr-2"
                            onclick="toggleModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}
</x-app-layout>
