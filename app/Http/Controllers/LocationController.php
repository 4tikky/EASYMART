<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class LocationController extends Controller
{
    /**
     * PROVINSI -> KAB/KOTA
     * URL: /locations/regencies/{provinceCode}
     */
    public function getRegencies(string $provinceCode): JsonResponse
    {
        $regencies = Regency::where('province_code', $provinceCode)
            ->orderBy('name')
            ->get(['code', 'name']);   // kirim CODE + NAME

        return response()->json($regencies);
    }

    /**
     * KAB/KOTA -> KECAMATAN
     * URL: /locations/districts/{cityCode}
     */
    public function getDistricts(string $cityCode): JsonResponse
    {
        $districts = District::where('city_code', $cityCode)
            ->orderBy('name')
            ->get(['code', 'name']);   // kirim CODE + NAME

        return response()->json($districts);
    }

    /**
     * KECAMATAN -> DESA/KELURAHAN
     * URL: /locations/villages/{districtCode}
     */
    public function getVillages(string $districtCode): JsonResponse
    {
        $villages = Village::where('district_code', $districtCode)
            ->orderBy('name')
            ->get(['code', 'name']);   // kalau nanti mau dipakai lagi bisa

        return response()->json($villages);
    }
}
