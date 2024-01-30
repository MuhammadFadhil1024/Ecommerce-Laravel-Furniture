<?php

namespace App\Http\Controllers;

use App\Helpers\RajaOngkir;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (request()->ajax()) {
        //     $address = Address::where('user_id', Auth::user()->id)->get();
        //     return DataTables::of($address)
        //         ->addColumn('action', function ($item) {
        //             return '
        //             <a href="' . route('dashboard.my-address.edit', $item->id) . '" class="inline-block bg-gray-500 text-white rounded-md px-2 py-1">
        //                 Edit
        //             </a>
        //                 <button onclick="toggleModal()" data-id="' . $item->id . '" class="inline-block bg-yellow-500 text-white rounded-md px-2 py-1 showAddress">
        //                     Detail
        //                 </button>
        //                     <form class="inline-block" action="' . route('dashboard.my-address.destroy', $item->id) . '" method="POST">
        //                         <button class="inline-block bg-red-500 text-white rounded-md px-2 py-1">
        //                             Delete
        //                         </button>
        //                     ' . method_field('delete') . csrf_field() . '
        //                     </form>
        //             <a href="' . route('dashboard.my-address.edit', $item->id) . '" class="inline-block bg-gray-500 text-white rounded-md px-2 py-1">
        //                 Set as primary address
        //             </a>
        //                     ';
        //         })
        //         ->rawColumns(['action'])
        //         ->make();

        // }

        $addresses = Address::where('user_id', Auth::user()->id)->get();
        // dd($adresses);

        return view('pages.dashboard.address.index', [
            'addresess' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $provinces = RajaOngkir::getProvinces();


        $cities = RajaOngkir::getAllCity();
        // dd($cities);
        $data = [];
        foreach ($cities as $key => $city) {
            $cityData = [
                'city_id' => $city['city_id'],
                'city' => $city['city_name'],
                'province_id' => $city['province_id'],
                'province' => $city['province']
            ];

            $data[] = $cityData;
        }

        // dd($data);

        return view('pages.dashboard.address.create', ['cities' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['provinces'] = $request->province_id;
        $data['city'] = $request->city_id;

        Address::create($data);

        return redirect()->route('dashboard.my-address.index')->with('success', 'success add new address');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $my_address = (array) DB::table('addresses')->find($id);

            $provinces = RajaOngkir::getCity($my_address['city'], $my_address['provinces']);

            $data = array_merge($my_address, $provinces);

            $result = [
                'full_name' => $data['full_name'],
                'telphone_number' => $data['telphone_number'],
                'detail_address' => $data['detail_address'],
                'province' => $data['province'],
                'city' => $data['city_name']
            ];

            return response()->json($result);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $my_address)
    {
        $cityData = RajaOngkir::getCity($my_address->city, $my_address->provinces);
        // dd($cityData);
        $city_address = $cityData['city_name'] . ', ' . $cityData['province'];

        $cities = RajaOngkir::getAllCity();
        // dd($cities);
        $data = [];
        foreach ($cities as $key => $city) {
            $cityData = [
                'city_id' => $city['city_id'],
                'city' => $city['city_name'],
                'province_id' => $city['province_id'],
                'province' => $city['province']
            ];

            $data[] = $cityData;
        }
        return view('pages.dashboard.address.edit', [
            'address' => $my_address,
            'city'  => $city_address,
            'cities' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $my_address)
    {
        // dd($request);
        $data = $request->all();
        $data['provinces'] = $request->province_id;
        $data['city'] = $request->city_id;

        $my_address->update($data);

        return redirect()->route('dashboard.my-address.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $my_address)
    {
        // dd($my_address);
        $my_address->delete();

        return redirect()->route('dashboard.my-address.index');
    }

    public function activateAddress(int $address_id)
    {
        try {
            $now_active_address = Address::where('user_id', Auth::user()->id)->where('is_active', 1)->first();
            // dd($now_active_address);

            if ($now_active_address) {
                $now_active_address->update(['is_active' => 0]);
                Address::where('id', $address_id)->update(['is_active' => 1]);
            } else {
                Address::where('id', $address_id)->update(['is_active' => 1]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // foreach ($now_active_address as $key => $value) {
        //     # code...
        // }

        // dd($address_id);
        return redirect()->back();
    }
}
