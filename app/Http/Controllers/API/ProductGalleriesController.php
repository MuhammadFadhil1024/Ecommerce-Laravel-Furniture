<?php

namespace App\Http\Controllers\API;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGalleryRequest;
use Illuminate\Support\Facades\Validator;

class ProductGalleriesController extends Controller
{
    public function index($product_id)
    {
        try {

            $response = product::with('galleries')->where('id', $product_id)->first();
            if ($response) {
                return response()->json(['message' => "success", 'data' => $response], 200);
            } else {
                return response()->json(['message' => 'data not found'], 422);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request, $product_id)
    {

        $validator = Validator::make($request->all(), [
            'files' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'failed update product', 'error' => $validator->errors()], 422);
        }

        try {

            $files = $request->file('files');
            $path = $files->store('public/gallery');

            $response = ProductGallery::create([
                'id_products' => $product_id,
                'url' => $path
            ]);

            return response()->json([
                'message' => 'success',
                'data' => ProductGallery::with('products')->where('id_products', $product_id)->first()
            ], 201);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function status(Request $request, $photo_id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'is_featured' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'failed update status', 'error' => $validator->errors()], 422);
        }

        try {

            $producGalleries = ProductGallery::find($photo_id);

            if ($producGalleries) {

                $producGalleries->is_featured = $request->is_featured;

                $producGalleries->save();

                return response()->json([
                    'message' => 'success',
                    'data' => $producGalleries
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($photo_id)
    {
        try {

            $prodctGallery = ProductGallery::find($photo_id);
            if ($prodctGallery) {
                $prodctGallery->delete();

                return response()->json(['message' => 'success'], 200);
            } else {
                return response()->json(['message' => 'product not found'], 401);
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
