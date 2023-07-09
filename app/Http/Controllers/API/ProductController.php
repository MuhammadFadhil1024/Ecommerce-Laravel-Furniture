<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $product = DB::table('products')->paginate(20);
            $response = [
                'message' => 'success',
                'data' => $product
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


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'failed insert product', 'error' => $validator->errors()], 422);
        }

        try {

            $product = $request->all();
            $product['slug'] = Str::slug($request->name);

            if (Product::where('slug', $product['slug'])->exists()) {
                return response()->json(['message' => 'product is available'], 422);
            }

            $product = Product::create($product);

            $response = [
                'message' => 'success',
                'data' => $product
            ];

            return response()->json($response, 201);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                return response()->json([
                    'message' => 'success',
                    'data' => $product
                ], 200);
            } else {
                return response()->json([
                    'message' => 'product not found'
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

    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'price' => 'required|integer',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'failed update product', 'error' => $validator->errors()], 422);
            }

            $product = Product::find($id);

            if ($product) {

                $product->name = $request->name;
                $product->price = $request->price;
                $product->slug = Str::slug($request->name);
                $product->description = $request->description;

                if (Product::where('slug', $product->slug)->exists()) {
                    return response()->json(['message' => 'product is available'], 422);
                }

                $product->save();

                return response()->json([
                    'message' => 'success',
                    'data' => $product
                ], 200);
            } else {
                return response()->json([
                    'message' => 'product not found'
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

    public function delete($id)
    {
        try {

            $product = Product::find($id);
            if ($product) {
                $product->delete();

                return response()->json(['message' => 'success'], 200);
            } else {
                return response()->json(['message' => 'product not found'], 404);
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
