<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback()
    {

        // set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat instance midtrans notification
        $notification = new Notification();

        // masukkan ke variable agar mudah ke pemanggilan
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // mendapatkan id transaksi
        $order = explode('-', $order_id); //hasil berbentuk array array 0 LUX array 1 id

        // mencari transaksi berdasarkan id
        $transaction = Transaction::findOrFail($order[1]);

        // handle notifikasi midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challengge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } elseif ($status = 'settlement') {
            $transaction->status = 'SUCCESS';
        } elseif ($status = 'pending') {
            $transaction->status = 'PENDING';
        } elseif ($status = 'deny') {
            $transaction->status = 'PENDING';
        } elseif ($status = 'expire') {
            $transaction->status = 'CANCELLED';
        } elseif ($status = 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // SIMPAN TRANSAKSI
        $transaction->save();

        // retutn respons untuk midtrans
        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success!'
            ]
        ]);
    }
}
