@extends('layouts.frontend')

@section('content')
    <!-- START: BREADCRUMB -->
    <section class="bg-gray-100 py-8 px-4">
        <div class="container mx-auto">
            <ul class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="#" aria-label="current-page">Checkout</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- END: BREADCRUMB -->


    <!-- START: COMPLETE YOUR ROOM -->
    <section class="md:py-16">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container mx-auto px-4">
            <!-- ADDRESS -->
            @if ($address != null)
                <div class="w-full md:px-4 mb-4" id="shipping-detail">
                    <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl">
                        <div class="flex flex-start mb-4">
                            <h3 class="text-2xl">Shipping Address</h3>
                        </div>
                        <div class="md:flex md:flex-wrap">
                            <div class="flex-none md:w-4/12">
                                <h3 class="text-xl font-semibold">{{ $address->type_of_place == 0 ? 'Home' : 'Office' }} -
                                    {{ $address->full_name }}
                                </h3>
                                <h3 class="text-xl font-semibold">{{ $address->telphone_number }}</h3>
                            </div>
                            <div class="py-2 md:py-0 text-lg md:w-5/12">
                                <p>
                                    {{ $address->detail_address }}
                                </p>
                            </div>
                            <div class="flex flex-wrap items-center mx-auto">
                                <div class="px-2 py-1 mr-3 shadow border border-red-600 text-red-600">
                                    First Address
                                </div>
                                <div class="text-blue-400">
                                    <a href="{{ route('dashboard.my-address.index') }}">Ubah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full
                                        md:px-4 mb-4">
                    <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl">
                        <div class="text-center py-1 text-red-600 mb-2">
                            <p>You don't have address click button below to add address</p>
                        </div>
                        <a href="{{ route('dashboard.my-address.index') }}"
                            class="bg-pink-400 focus:outline-none py-2 rounded-lg text-medium transition-all duration-200 px-6">
                            + Add adress
                        </a>
                    </div>
                </div>
            @endif
            <!-- END: ADDRESS -->

            <div class="w-full md:px-4 mb-4" id="shipping-detail">
                <div class="w-full bg-gray-100 px-4 md:mb-0 py-6 md:rounded-3xl" id="shopping-cart">
                    <div class="flex flex-start mb-4 md:px-4  pb-3 border-b border-gray-200 md:border-b-0">
                        <h3 class="text-2xl">Product ordered</h3>
                    </div>

                    <div class="border-b border-gray-200 mb-4 md:px-4 hidden md:block">
                        <div class="flex flex-start items-center pb-2 -mx-4">
                            <div class="px-4 flex-none">
                                <div class="" style="width: 40px">
                                    <h6>Photo</h6>
                                </div>
                            </div>
                            <div class="px-4 w-5/12">
                                <div class="">
                                    <h6>Product</h6>
                                </div>
                            </div>
                            <div class="px-4 w-2/12">
                                <div class="text-left">
                                    <h6>Qty</h6>
                                </div>
                            </div>
                            <div class="px-4 w-2/12">
                                <div class="">
                                    <h6>Price</h6>
                                </div>
                            </div>
                            <div class="px-4 w-2/12">
                                <div class="text-right">
                                    <h6>Subtotal</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    @forelse ($carts['carts'] as $item)
                        {{-- @dd($item); --}}
                        <!-- START: ROW 1 -->
                        <div class="flex flex-start flex-wrap items-center md:px-4 mb-8 -mx-4" data-row="1">
                            <div class="px-4 flex-none">
                                <div class="" style="width: 40px; height: 40px">
                                    <img src="{{ $item['carts']->product->galleries()->exists() ? Storage::url($item['carts']->product->galleries->first()->url) : 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' }}"
                                        alt="chair-1" class="object-cover rounded-xl w-full h-full" />
                                </div>
                            </div>
                            <div class="px-4 w-auto md:w-5/12">
                                <div class="">
                                    <h6 class="font-semibold text-lg md:text-xl leading-8">
                                        {{ $item['carts']->product->name }}
                                    </h6>
                                    <h6 class="md:hidden">{{ $item['carts']->quantity }}</h6>
                                    <h6 class="font-semibold text-base md:text-lg block md:hidden">
                                        IDR {{ number_format($item['carts']->product->price) }}
                                    </h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:w-2/12 hidden md:block">
                                <div class="">
                                    <h6 class="font-semibold text-lg">{{ $item['carts']->quantity }}</h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:w-2/12 hidden md:block">
                                <div class="">
                                    <h6 class="font-semibold text-lg">IDR
                                        {{ number_format($item['carts']->product->price) }}</h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:w-2/12 hidden md:block">
                                <div class="text-right">
                                    <h6 class="font-semibold text-lg">IDR
                                        {{ number_format($item['subTotal']) }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 font-semibold text-lg md:text-xl md:hidden">
                            Sub total : IDR {{ number_format($item['subTotal']) }}
                        </div>
                        <!-- END: ROW 1 -->
                    @empty
                        <p id="cart-empty" class="text-center py-8">
                            Ooops... Cart is empty
                            <a href="{{ route('index') }}" class="underline">Shop Now</a>
                        </p>
                    @endforelse


                    <div class="border-t px-4">
                        <div class="text-lg mt-4 font-semibold text-gray-600 mb-4">
                            Courier :
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="">
                                <div
                                    class="py-1 md:text-lg text-center font-semibold rounded shadow border border-red-600 text-red-600 bg-gray-200">
                                    <select id="courier" class="px-2 bg-gray-200">
                                        <option> Select courier </option>
                                        <option value="jne">JNE OKE</option>
                                        <option value="pos">POS REG</option>
                                        <option value="tiki">TIKI REG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="" id="costCourierSection">
                                <h6 class="md:font-semibold md:text-lg coast">IDR 0</h6>
                            </div>
                        </div>
                        {{-- <div class="mt-4" id="estimate">
                            Sampai pada perkiraan tanggal 16 - 17
                        </div> --}}
                    </div>
                    <div class="flex justify-start border-t mt-4 px-4">
                        <div class="md:flex mt-4 gap-4">
                            <div class="text-gray-600 font-bold">
                                <p>
                                    Total pesanan {{ $carts['productAmount'] }} produk:
                                </p>
                            </div>
                            <div>
                                <p>
                                    IDR {{ number_format($carts['totalPrice']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:px-4 mb-4">
                <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl mt-4">
                    <div class="flex justify-start lg:justify-end font-normal text-base md:font-medium md:text-lg">
                        <div class="md:w-1/2">
                            <div class="flex justify-between items-center mb-2 gap-4">
                                <div>
                                    Total product
                                </div>
                                <div>
                                    IDR {{ number_format($carts['totalPrice']) }}
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    Courier cost
                                </div>
                                <div id="totalPaymentCoastCourier">
                                    IDR 0
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    Total payment
                                </div>
                                <div id="totalPayment">
                                    IDR {{ number_format($carts['totalPrice']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <form class="buttonCheckout">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
                            <button type="submit" class="bg-pink-400 px-4 py-2 rounded font-semibold text-base md:text-lg">
                                Make an order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Modal -->
        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modal">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full border-2">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label class="font-medium text-gray-800">Name</label>
                        <input type="text" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" />
                        <label class="font-medium text-gray-800">Url</label>
                        <input type="text" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" />
                    </div>
                    <div class="bg-gray-200 px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                            onclick="toggleModal()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="button" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: COMPLETE YOUR ROOM -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script>
        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden')
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.buttonCheckout').on('submit', function (e) {
                e.preventDefault();

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                // var costCourier = $('#costCourierSection').text();
                var totalPayment = $('#totalPayment').text();
                // var cleaningCostCourier = costCourier.replace(/IDR\s*/, '');
                var cleaningTotalPayment = totalPayment.replace(/IDR\s*/, '').replace(/,00$/, '')
                var addresId = {{ $address->id }}
                var courier = $('#courier').find(":selected").val();
                // var courier = $(this).val('#courier')
                // console.log(courier);

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '/finalization',
                    data: {
                        _token: CSRF_TOKEN,
                        address_id : addresId,
                        courier : courier,
                        totalPayment: cleaningTotalPayment
                    },
                    success: function (response){
                        console.log(response);
                        window.location = response.url;
                    },
                    error: function(error){
                        console.log(error);
                    }
                })

                console.log('checkout');
            })
        })
    </script>

    <script>
        $('#courier').on('change', function() {
            var courier = $(this).val();
            // console.log(courier);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var destination = {{ $address->city }}
            var totalWeight = {{ $totalWeight }}

            $.ajax({
                url: '/costcourier',
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                data: {
                    _token: CSRF_TOKEN,
                    courier: courier,
                    destination: destination,
                    weight: 8000,
                },
                success: function(response) {
                    var formattedAmountCostCourier = 'IDR ' + String(response.data[0].value).replace(
                        /\B(?=(\d{3})+(?!\d))/g, '.');

                    var totalProductPrice = {{ $carts['totalPrice'] }}
                    var costCourierValue = response.data[0].value;

                    var sumTotalPayment = parseFloat(totalProductPrice) + parseFloat(costCourierValue);

                    // Format the sumTotalPayment as Rupiah
                    var sumTotalPaymentFormatted = 'IDR ' + sumTotalPayment.toLocaleString('id-ID', {
                        minimumFractionDigits: 2
                    });

                    console.log('costCourierValue:', costCourierValue);
                    console.log('totalProductPrice:', totalProductPrice);
                    console.log('sumTotalPayment:', sumTotalPayment);

                    // Update the HTML elements
                    $('#costCourierSection h6').text(formattedAmountCostCourier);
                    $('#totalPaymentCoastCourier').text(formattedAmountCostCourier);
                    $('#totalPayment').text(sumTotalPaymentFormatted);
                },
                error: function(error) {
                    // Handle error here
                    console.error(error);
                }



            })
        });
    </script>
@endsection
