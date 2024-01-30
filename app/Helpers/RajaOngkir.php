<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;

class RajaOngkir
{

    public static function getProvinces()
    {
        try {

        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->get('https://api.rajaongkir.com/starter/province'
        );

        $data = json_decode($response, true);
        $provinces = $data['rajaonkir']['results'];
        return $provinces;

        } catch (Exception $e) {
            return response()->json( $e->getMessage() );
        }
    }

    static function getCity(int $cityId, int $provincesId)
    {
        try {
            $url = "https://api.rajaongkir.com/starter/city?id=$cityId&province=$provincesId";

            $response = Http::withHeaders(['key' => config('services.rajaongkir.key')
                ])->get($url);

            $data = json_decode($response, true);
            $provinces = $data['rajaongkir']['results'];
            // dd($data);
            return $provinces;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }

    static function getAllCity()
    {
        try {

            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get('https://api.rajaongkir.com/starter/city'
            );
    
            $data = json_decode($response, true);
            $provinces = $data['rajaongkir']['results'];
            return $provinces;
    
            } catch (Exception $e) {
                return response()->json( $e->getMessage() );
            }

    }
}