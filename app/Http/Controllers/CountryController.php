<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;
use OpenApi\Annotations as OA;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/countries",
     *     summary="Get all countries",
     *      tags={"Country"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of countries",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Country")
     *         )
     *     )
     * )
     */
    public function getAllCountries(): JsonResponse
    {
        $countries = Country::all();
        return response()->json($countries);
    }
}
