<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                            <a href="' . route('dashboard.category.edit', $item->id) . '" class="inline-block bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                                Edit
                            </a>
                            <a href="' . route('dashboard.product.gallery.index', $item->id) . '" class="inline-block bg-green-500 text-white rounded-md px-2 py-1 m-2">
                                Gallery
                            </a>
                            <form class="inline-block" action="' . route('dashboard.category.destroy', $item->id) . '" method="POST">
                                <button class="inline-block bg-red-500 text-white rounded-md px-2 py-1 m-2">
                                    Delete
                                </button>
                            ' . method_field('delete') . csrf_field() . '
                            </form>';
                })
                ->editColumn('thumbnile_category_url', function($item){
                    return '<img style="max: width 150pxW;" src="'. Storage::url($item->thumbnile_category_url) .'"/>';
                })
                ->rawColumns(['action', 'thumbnile_category_url'])
                ->make();
        }
        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
