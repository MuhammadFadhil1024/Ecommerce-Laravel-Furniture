<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Address;
use App\Models\product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $products = product::with(['galleries'])->latest()->get();

        return view('pages/frontend/index', compact('products'));
    }

    public function details(Request $request, $slug)
    {
        $product = product::with(['galleries'])->where('slug', $slug)->firstOrFail();

        $recomendations = product::with(['galleries'])->InRandomOrder()->limit(4)->get();

        return view('pages/frontend/details', compact('product', 'recomendations'));
    }

    public function cartAdd(Request $request, int $id)
    {
        try {
            
            if (count(Auth::user()->carts) > 0) {
                $dataProductCustomerOnCart = Cart::where('id_users', Auth::user()->id)->get();

                foreach ($dataProductCustomerOnCart as $key => $product) {
                        // dd($product->id_products == $id);
                    if ($product->id_products === $id) {
                        $selectedProductOnCart = Cart::find($product->id);
                        // dd($selectedProductOnCart);
                        $selectedProductOnCart->quantity = $selectedProductOnCart->quantity + $request->quantityValue;
                        $selectedProductOnCart->save();
                    } else {
                        Cart::create([
                            'id_users' => Auth::user()->id,
                            'id_products' => $id,
                            'quantity' => $request->quantityValue
                        ]);
                    }
                }
            } else {
                Cart::create([
                    'id_users' => Auth::user()->id,
                    'id_products' => $id,
                    'quantity' => $request->quantityValue
                ]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect('cart');
    }

    public function cart(Request $request)
    {
        // $provinces = RajaOngkir::getProvinces();

        $carts = Cart::with(['product.galleries'])->where('id_users', Auth::user()->id)->get();

        // summ all price from cart
        $total_carts_price = 0;
        foreach ($carts as $key => $value) {
            $total_carts_price += $value->product->price * $value->quantity;
        }

        // dd($carts);

        return view('pages/frontend/cart', [
            'carts' => $carts,
            'total_carts_price' => $total_carts_price
        ]);
    }

    public function cartDelete(Request $request, $id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect('cart');
    }

    public function checkout(Request $request)
    {

        $address = Address::where('user_id', Auth::user()->id)->where('is_active', 1)->first();
        // dd($address);

        $carts = Cart::with(['product.galleries'])->where('id_users', Auth::user()->id)->get();
        // dd($carts);
        
        $collectionCarts = $carts->collect();
        // dd($collectionCarts);
        $dataCartsMap = $collectionCarts->map(function ($carts, $key) {
            return [
                'carts' => $carts,
                'subTotal' => $carts->quantity * $carts->product->price,
                'totalWeightProduct' => $carts->product->weight * $carts->quantity
            ];
        });

        $totalPrice = $dataCartsMap->sum('subTotal');
        $totalWeight = $dataCartsMap->sum('totalWeightProduct');

        // dd([$dataCartsMap, $dataCartsMap->sum('subTotal')]);
        // dd($totalWeight);




        return view('pages/frontend/checkout', [
            'carts' => [
                'carts' => $dataCartsMap,
                'totalPrice' => $totalPrice,
                'productAmount' => count($carts),
            ],
            'address' => $address,
            'totalWeight' => $totalWeight
        ]);
    }

    public function checkCourierCost(Request $request)
    {
        // dd($request);
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => '501',
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ]);

        $dataCostCourier = $response->json();

        $costCourier = [];

        foreach ($dataCostCourier['rajaongkir']['results'] as $result) {
            foreach ($result['costs'] as $cost) {
                foreach ($cost['cost'] as $value) {
                    $costCourier[] = [
                        'service' => $cost['service'],
                        'description' => $cost['description'],
                        'value' => $value['value'],
                        'etd' => $value['etd']
                    ];
                }
            }
        }

        return response()->json([
            'status' => 200,
            'data' => $costCourier
        ]);
    }

    public function finalization(Request $request)
    {
        // dd($request->address);
        $data = $request->all();

        $cleaningTotalPayment = str_replace('.', '', $request->totalPayment);

        //  mengambil data di table cart
        $carts = Cart::with(['product'])->where('id_users', Auth::user()->id)->get();

        // menambah data ke table transaksi
        $data['id_users'] = Auth::user()->id;
        $data['address_id'] = $request->address_id;
        $data['total_price'] = $cleaningTotalPayment;
        $data['courier'] = $request->courier;

        // membuat table transaction
        $transaction = Transaction::create($data);

        foreach ($carts as $cart) {
            // menambah data ke table transaction item
            $items[] = TransactionItem::create([
                'id_transactions' => $transaction->id,
                'id_users' => $cart->id_users,
                'id_products' => $cart->id_products
            ]);

            // decrase quantity on product
            $product = product::find($cart->id_products);
            $product->stock = $product->stock - $cart->quantity;
            $product->save();

        }

        // menghapus keranjang setelah checkout
        Cart::where('id_users', Auth::user()->id)->delete();        

        // konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // setup variable midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => 'LUX-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email
            ],
            'enabled_payment' => ['gopay', 'bank_transfer'],
            'vtweb' => []
        ];

        // proses pembayaran
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Redirect to Snap Payment Page
            return response()->json(['url' => url($paymentUrl)]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
            // echo $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        return view('pages/frontend/success');
    }

    public function incraseQuantity(Request $request)
    {
        try {
            $productOnCart = Cart::find($request->productItemCartId);

            $productOnCart->quantity = $productOnCart->quantity + 1;

            $productOnCart->save();

            return response()->json($productOnCart->quantity);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function decraseQuantity(Request $request)
    {
        try {
            $productOnCart = Cart::find($request->productItemCartId);
            
            $productOnCart->quantity = $productOnCart->quantity - 1;
            
            $productOnCart->save();
            
            return response()->json($productOnCart->quantity);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
