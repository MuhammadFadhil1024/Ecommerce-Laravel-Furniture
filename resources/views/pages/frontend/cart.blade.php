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
                    <a href="#" aria-label="current-page">Shopping Cart New</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- END: BREADCRUMB -->

    <!-- START: COMPLETE YOUR ROOM -->
    <section class="md:py-16" id="section-cart">
        <div class="container mx-auto px-4">
            {{-- <div class="flex -mx-4 flex-wrap"> --}}
            <div class="w-full px-4 mb-4 md:mb-0" id="shopping-cart">
                <div class="flex flex-start mb-4 mt-8 pb-3 border-b border-gray-200 md:border-b-0">
                    <h3 class="text-2xl">Shopping Cart</h3>
                </div>

                <div class="border-b border-gray-200 mb-4 hidden md:block">
                    <div class="flex flex-start items-center pb-2 -mx-4">
                        <div class="px-4 flex-none">
                            <div class="" style="width: 80px">
                                <h6>Photo</h6>
                            </div>
                        </div>
                        <div class="px-4 w-5/12">
                            <div class="">
                                <h6>Product</h6>
                            </div>
                        </div>
                        <div class="px-4 w-2/12">
                            <div class="text-center">
                                <h6>Price</h6>
                            </div>
                        </div>
                        <div class="px-4 w-2/12">
                            <div class="text-center">
                                <h6>Quantity</h6>
                            </div>
                        </div>
                        <div class="px-4 w-1/12">
                            <div class="text-center">
                                <h6>Action</h6>
                            </div>
                        </div>
                    </div>
                </div>

                @forelse ($carts as $item)
                    <!-- START: ROW 1 -->
                    <div class="flex flex-start flex-wrap items-center mb-4 -mx-4" data-row="1">
                        <div class="px-4 flex-none">
                            <div class="" style="width: 80px; height: 80px">
                                <img src="{{ $item->product->galleries()->exists() ? Storage::url($item->product->galleries->first()->url) : 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' }}"
                                    alt="chair-1" class="object-cover rounded-xl w-full h-full" />
                            </div>
                        </div>
                        <div class="px-4 w-auto md:w-5/12">
                            <div class="">
                                <h6 class="font-semibold text-lg md:text-xl leading-8 mb-2">
                                    {{ $item->product->name }}
                                </h6>
                                <div class="text-sm md:text-lg mb-4">Office Room</div>
                                <div class="flex justify-center md:hidden mb-4">
                                    <form class="decrase-quantity-form" data-product-id="{{ $item->id }}">
                                        @csrf
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <input type="hidden" value="{{ $item->id }}" id="productItemCartId">
                                        <button type="submit"
                                            class="font-semibold text-lg px-4 border border-gray-600">-</button>
                                    </form>
                                    <h6 class="font-semibold text-lg px-4 border border-gray-600 quantityDisplayMobile"
                                        data-product-id="{{ $item->id }}" name="quantity">{{ $item->quantity }}</h6>
                                    <form class="incrase-quantity-form" data-product-id="{{ $item->id }}">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <input type="hidden" value="{{ $item->id }}" id="productItemCartId">
                                        <button type="submit"
                                            class="font-semibold text-lg px-4 border border-gray-600">+</button>
                                    </form>
                                </div>
                                <h6 class="font-semibold text-base md:text-lg block md:hidden">
                                    IDR {{ number_format($item->product->price) }}
                                </h6>
                            </div>
                        </div>
                        <div class="px-4 w-auto flex-none md:w-2/12 hidden md:block">
                            <div class="text-center">
                                <h6 class="font-semibold text-lg">IDR {{ number_format($item->product->price) }}</h6>
                            </div>
                        </div>
                        <div class="px-4 w-auto flex-none md:w-2/12 hidden md:block">
                            <div class="flex justify-center">
                                <form class="decrase-quantity-form" data-product-id="{{ $item->id }}">
                                    @csrf
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $item->id }}" id="productItemCartId">
                                    <button type="submit"
                                        class="font-semibold text-lg px-4 border border-gray-600">-</button>
                                </form>
                                <h6 class="font-semibold text-lg px-4 border border-gray-600 quantityDisplayWeb"
                                    data-product-id="{{ $item->id }}" name="quantity">{{ $item->quantity }}</h6>
                                <form class="incrase-quantity-form" data-product-id="{{ $item->id }}">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $item->id }}" id="productItemCartId">
                                    <button type="submit"
                                        class="font-semibold text-lg px-4 border border-gray-600">+</button>
                                </form>
                            </div>
                        </div>
                        <div class="px-4 md:w-1/12">
                            <div class="text-center">
                                <form action="{{ route('cart-delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 border-none focus:outline-none px-3 py-1">
                                        X
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END: ROW 1 -->
                @empty
                    <p id="cart-empty" class="text-center py-8">
                        Ooops... Cart is empty
                        <a href="{{ route('index') }}" class="underline">Shop Now</a>
                    </p>
                @endforelse

            </div>
            <div class="flex justify-between items-center mx-auto bg-gray-100 rounded-xl px-6 py-8 mt-8">
                <div class="px-4">
                    <h4 class="font-semibold text-lg md:text-xl">
                        Total IDR
                    </h4>
                    <p class="text-lg md:text-xl">
                        {{ number_format($total_carts_price) }}
                    </p>
                </div>
                <div class="md:shrink w-6/12">
                    <a type="button" href="{{ route('checkout') }}"
                        class="bg-pink-400 text-black hover:bg-black hover:text-pink-400 focus:outline-none w-full py-3 rounded-full text-center md:text-lg focus:text-black transition-all duration-200 px-6">
                        Checkout
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- END: COMPLETE YOUR ROOM -->
    <script>
        $(document).ready(function () {
    
            // FUNCTION FOR INCREASE QUANTITY CART 
            $('.incrase-quantity-form').on('submit', function (e) {
                e.preventDefault();
    
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var productId = $(this).data('product-id');
    
                $.ajax({
                    type: 'PUT',
                    dataType: 'json',
                    url: '/cart/incrasequantity',
                    data: {
                        _token: CSRF_TOKEN,
                        quantity: 1,
                        productItemCartId: productId
                    },
                    success: function (response) {
                        console.log(response);
                        updateQuantityDisplay(productId, response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            // END OF FUNCTION FOR INCREASE QUANTITY CART 
    
            // FUNCTION FOR DECREASE QUANTITY CART 
            $('.decrase-quantity-form').on('submit', function (e) {
                e.preventDefault();
    
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var productId = $(this).data('product-id');
                var quantityDisplayWeb = $('.quantityDisplayWeb[data-product-id="' + productId + '"]');
                var quantityDisplayMobile = $('.quantityDisplayMobile[data-product-id="' + productId + '"]');
                var quantityValueWeb = parseInt(quantityDisplayWeb.text());
                var quantityValueMobile = parseInt(quantityDisplayMobile.text());
    
                if (quantityValueWeb > 1) {
                    // If quantity is greater than 1, decrease the quantity
                    $.ajax({
                        type: 'PUT',
                        dataType: 'json',
                        url: '/cart/decrasequantity/',
                        data: {
                            _token: CSRF_TOKEN,
                            quantity: 1,
                            productItemCartId: productId
                        },
                        success: function (response) {
                            console.log(response);
                            updateQuantityDisplay(productId, response);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                } else {
                    // If quantity is 1 or less, prompt for deletion or take appropriate action
                    console.log('quantity is 1 or less');
                    // Disable the decrease button for the specific product
                    $('.decrase-quantity-form[data-product-id="' + productId + '"] button').prop('disabled', true);
                }
            });
            // END OF FUNCTION FOR DECREASE QUANTITY CART 
    
            // Function to update quantity display for a specific product
            function updateQuantityDisplay(productId, newQuantity) {
                var quantityDisplayWeb = $('.quantityDisplayWeb[data-product-id="' + productId + '"]');
                var quantityDisplayMobile = $('.quantityDisplayMobile[data-product-id="' + productId + '"]');
                quantityDisplayWeb.text(newQuantity);
                quantityDisplayMobile.text(newQuantity);
                // Enable the decrease button after updating the quantity
                $('.decrase-quantity-form[data-product-id="' + productId + '"] button').prop('disabled', false);
            }
        });
    </script>
        
@endsection
