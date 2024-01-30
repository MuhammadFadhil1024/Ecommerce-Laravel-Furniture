<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction #{{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url : '{!! url()->current() !!}'
                    // url yang sedang dibuka sekarang
                },
                columns: [
                    {data : 'id', name: 'id', width: '5%'},
                    {data : 'product.name', name: 'product.name'},
                    {data : 'product.price', name: 'product.price'}
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg text-gray-800 leading-light mb-5">
                Transaction Details
            </h2>

            <div class="bg-white overflow-hidden shadow sm-rounded-lg mb-10">
                <div class="p-6 bg-white border-c border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-4 text-right">Name</th>
                                <td class="border px-6 py-4">{{$transaction->users->name}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Email</th>
                                <td class="border px-6 py-4">{{$transaction->users->email}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Alamat</th>
                                <td class="border px-6 py-4">Provinsi {{$address['province']}} {{ $address['type'] }} {{ $address['city_name'] }}, {{ $address['postal_code'] }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Phone</th>
                                <td class="border px-6 py-4">{{$transaction->adresses->telphone_number}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Kurir</th>
                                <td class="border px-6 py-4">{{$transaction->courier}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Payment</th>
                                <td class="border px-6 py-4">{{$transaction->payment}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Alamat Pembayaran</th>
                                <td class="border px-6 py-4">{{$transaction->payment_url}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Total harga</th>
                                <td class="border px-6 py-4">{{$transaction->total_price}}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Status</th>
                                <td class="border px-6 py-4">{{$transaction->status}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="font-semibold text-lg text-gray-800 leading-light mb-5">
                Transaction Item
            </h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
