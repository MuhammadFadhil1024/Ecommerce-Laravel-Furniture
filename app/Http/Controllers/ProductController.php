<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                            <a href="' . route('dashboard.product.edit', $item->id) . '" class="inline-block bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                                Edit
                            </a>
                            <a href="' . route('dashboard.product.gallery.index', $item->id) . '" class="inline-block bg-green-500 text-white rounded-md px-2 py-1 m-2">
                                Gallery
                            </a>
                            <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                                <button class="inline-block bg-red-500 text-white rounded-md px-2 py-1 m-2">
                                    Delete
                                </button>
                            ' . method_field('delete') . csrf_field() . '
                            </form>';
                })
                ->rawColumns(['action'])
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->make();
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', [
            'item' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // dd($product);
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
