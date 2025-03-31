<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    /**
     * Get all countries
     *
     * @return JsonResponse
     */
    public function index()
    {
        $countries = Country::all();

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }
}
