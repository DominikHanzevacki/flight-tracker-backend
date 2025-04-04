<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller;
use OpenApi\Annotations as OA;

class AirlineController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/airlines",
     *     summary="Get all airlines",
     *     tags={"Airline"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of airlines",
     *         @OA\JsonContent(
     *             type="array",
     *            @OA\Items(ref="#/components/schemas/Airline")
     *         )
     *     )
     * )
     */
    public function getAllAirlines(): JsonResponse
    {
        return response()->json(
            Airline::with('country')->get()->map(function ($airline) {
                return [
                    'id' => $airline->id,
                    'name' => $airline->name,
                    'country' => [
                        'id' => $airline->country->id,
                        'name' => $airline->country->name,
                        'code' => $airline->country->code,
                    ],
                ];
            })
        );
    }

    /**
     * @OA\Get(
     *     path="/api/airlines/{id}",
     *     summary="Get airline by ID",
     *      tags={"Airline"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airline details",
     *         @OA\JsonContent(ref="#/components/schemas/Airline")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airline not found"
     *     )
     * )
     */
    public function getAirlineById(int $id): JsonResponse
    {
        $airline = Airline::with('country')->find($id);

        if (!$airline) {
            return response()->json(['error' => 'Airline not found'], 404);
        }

        return response()->json([
            'id' => $airline->id,
            'name' => $airline->name,
            'country' => [
                'name' => $airline->country->name,
                'code' => $airline->country->code,
            ],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/airlines",
     *     summary="Create a new airline",
     *      tags={"Airline"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "country_id"},
     *             @OA\Property(property="name", type="string", maxLength=100),
     *             @OA\Property(property="country_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Airline created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Airline")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createAirline(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'country_id' => 'sometimes|required|integer|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $airline = new Airline();
        $airline->name = $request->name;
        $airline->country_id = $request->country_id;
        $airline->save();

        return response()->json([
            'message' => 'Airline created successfully',
            'data' => [
                'id' => $airline->id,
                'name' => $airline->name,
                'country' => [
                    'name' => $airline->country->name,
                    'code' => $airline->country->code,
                ],
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/airlines/{id}",
     *     summary="Update an existing airline",
     *      tags={"Airline"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=100),
     *             @OA\Property(property="country_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airline updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Airline")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airline not found"
     *     )
     * )
     */
    public function updateAirline(Request $request, $id): JsonResponse
    {
        $airline = Airline::with('country')->find($id);

        if (!$airline) {
            return response()->json(['error' => 'Airline not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'country_id' => 'sometimes|required|integer|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->has('name')) {
            $airline->name = $request->name;
        }

        if ($request->has('country_id')) {
            $airline->country_id = $request->country_id;
        }

        $airline->save();
        $airline->load('country');

        return response()->json([
            'message' => 'Airline updated successfully',
            'data' => [
                'id' => $airline->id,
                'name' => $airline->name,
                'country' => [
                    'name' => $airline->country->name,
                    'code' => $airline->country->code,
                ],
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/airlines/{id}",
     *     summary="Delete an airline",
     *      tags={"Airline"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airline deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airline not found"
     *     )
     * )
     */
    public function deleteAirline($id): JsonResponse
    {
        $airline = Airline::with('country')->find($id);

        if (!$airline) {
            return response()->json(['error' => 'Airline not found'], 404);
        }

        $airline->delete();

        return response()->json(['message' => 'Airline deleted successfully'], 200);
    }
}
