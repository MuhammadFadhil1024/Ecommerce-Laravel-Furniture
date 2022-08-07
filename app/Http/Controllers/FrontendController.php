<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

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

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'id_users' => Auth::user()->id,
            'id_products' => $id
        ]);

        return redirect('cart');
    }

    public function cart(Request $request)
    {
        $carts = Cart::with(['product.galleries'])->where('id_users', Auth::user()->id)->get();

        return view('pages/frontend/cart', compact('carts'));
    }

    public function cartDelete(Request $request, $id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect('cart');
    }

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        //  mengambil data di table cart
        $carts = Cart::with(['product'])->where('id_users', Auth::user()->id)->get();

        // menambah data ke table transaksi
        $data['id_users'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('product.price');

        // membuat table transaction
        $transaction = Transaction::create($data);

        // menambah data ke table transaction item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'id_transactions' => $transaction->id,
                'id_users' => $cart->id_users,
                'id_products' => $cart->id_products
            ]);
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
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        return view('pages/frontend/success');
    }
}
