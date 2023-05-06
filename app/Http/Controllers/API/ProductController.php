<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $product = product::all();

        $response = [
            'message' => 'List Product',
            'data' => $product
        ];

        return response()->json($response, Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            // $product = product::create($request->all());
            $product = $request->all();
            $product['slug'] = Str::slug($request->name);
            Product::create($product);

            $response = [
                'message' => 'Product Create',
                'data' => $product
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json(
                [
                    'message' => "Failed" . $e->errorInfo
                ]
            );
        }
    }
}
