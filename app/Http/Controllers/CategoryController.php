<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
                            <button onclick="editCategory('. $item->id .')" class="inline-block bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                                Edit
                            </button>
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
                ->editColumn('name', function($item){
                    return $item->category_name;
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()->all()[0]], 400);
        }

        $thumbnail = $request->file('thumbnail');
        if ($request->hasFile('thumbnail')) {

            $thumbnailPath = $thumbnail->store('public/category');

            Category::create([
                'category_name' => $request->name,
                'thumbnile_category_url' => $thumbnailPath
            ]);
        }

        // $thumbnailPath = $request->file('thumbnail')->store('thumbnails');


        return response()->json(['success' => 'Category saved successfully.']);
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
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()->all()[0]], 400);
        }
    
        $category = Category::findOrFail($id);
    
        // Check if new thumbnail is uploaded
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($category->thumbnail) {
                Storage::delete($category->thumbnail);
            }
    
            // Store new thumbnail
            $filePath = $request->file('thumbnail')->store('thumbnails');
            $category->thumbnail = $filePath;
        }
    
        $category->category_name = $request->name;
        $category->save();
    
        return response()->json(['success' => 'Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');

    } catch (\Exception $e) {
            return response()->json(['errors' => 'An occured Error']);
        }
    }
}
