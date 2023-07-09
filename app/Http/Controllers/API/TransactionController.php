<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        try {

            $transaction = DB::table('transactions')->paginate('10');

            $response = [
                'message' => 'success',
                'data' => $transaction
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => 'failed update status transaction', 'error' => $validator->errors()], 422);
        }

        try {

            $transaction = Transaction::find($id);

            if ($transaction) {
                $transaction->status = $request->status;

                $transaction->save();

                return response()->json([
                    'message' => 'success',
                    'data' => $transaction
                ], 200);
            } else {
                return response()->json([
                    'message' => 'transaction not found'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $transaction = Transaction::find($id);

            if ($transaction) {
                return response()->json([
                    'message' => 'success',
                    'data' => $transaction
                ], 200);
            } else {
                return response()->json([
                    'message' => 'transaction not found'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
