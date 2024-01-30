<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function justArrived()
    {
        try {

            $justarrived = DB::table('products')->orderBy('created_at', 'asc')->limit(10)->get();

            $response = [
                'message' => 'success',
                'data' => $justarrived
            ];

            return response()->json( $response, 200);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
