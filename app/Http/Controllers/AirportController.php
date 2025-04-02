<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller;
use OpenApi\Annotations as OA;

class AirportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/airports",
     *     summary="Get all airports",
     *     tags={"Airport"},
     *     @OA\Response(
     *         response=200,
     *         description="List of airports",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Airport")
     *         )
     *     )
     * )
     */
    public function getAllAirports(): JsonResponse
    {
        return response()->json(Airport::with('country', 'airlines', 'position')->get());
    }

    /**
     * @OA\Get(
     *     path="/api/airports/{id}",
     *     summary="Get airport by ID",
     *     tags={"Airport"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airport details",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     )
     * )
     */
    public function getAirportById(int $id): JsonResponse
    {
        $airport = Airport::with('country', 'airlines', 'position')->find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        return response()->json($airport);
    }

    /**
     * @OA\Post(
     *     path="/api/airports",
     *     summary="Create a new airport",
     *     tags={"Airport"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "country_id", "position"},
     *             @OA\Property(property="name", type="string", maxLength=100),
     *             @OA\Property(property="country_id", type="integer"),
     *             @OA\Property(
     *                 property="position",
     *                 type="object",
     *                 required={"latitude", "longitude"},
     *                 @OA\Property(property="latitude", type="number", format="float"),
     *                 @OA\Property(property="longitude", type="number", format="float")
     *             ),
     *             @OA\Property(
     *                 property="airlines",
     *                 type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Airport created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createAirport(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'country_id' => 'required|integer|exists:countries,id',
            'position.latitude' => 'required|numeric',
            'position.longitude' => 'required|numeric',
            'airlines.*' => 'integer|exists:airlines,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $position = new Position();
        $position->latitude = $request->input('position.latitude');
        $position->longitude = $request->input('position.longitude');
        $position->save();

        $airport = new Airport();
        $airport->name = $request->name;
        $airport->country_id = $request->country_id;
        $airport->position_id = $position->id;
        $airport->save();

        if ($request->has('airlines')) {
            $airport->airlines()->sync($request->airlines);
        }

        return response()->json($airport->load('country', 'airlines', 'position'), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/airports/{id}",
     *     summary="Update an existing airport",
     *     tags={"Airport"},
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
     *             @OA\Property(property="country_id", type="integer"),
     *             @OA\Property(
     *                 property="position",
     *                 type="object",
     *                 @OA\Property(property="latitude", type="number", format="float"),
     *                 @OA\Property(property="longitude", type="number", format="float")
     *             ),
     *             @OA\Property(
     *                 property="airlines",
     *                 type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airport updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     )
     * )
     */
    public function updateAirport(Request $request, int $id): JsonResponse
    {
        $airport = Airport::with('country', 'airlines', 'position')->find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'country_id' => 'sometimes|required|integer|exists:countries,id',
            'position.latitude' => 'sometimes|required|numeric',
            'position.longitude' => 'sometimes|required|numeric',
            'airlines' => 'sometimes|array',
            'airlines.*' => 'integer|exists:airlines,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->has('name')) {
            $airport->name = $request->name;
        }

        if ($request->has('country_id')) {
            $airport->country_id = $request->country_id;
        }

        if ($request->has('position.latitude') && $request->has('position.longitude')) {
            $airport->position->update([
                'latitude' => $request->input('position.latitude'),
                'longitude' => $request->input('position.longitude'),
            ]);
        }

        $airport->save();

        if ($request->has('airlines')) {
            $airport->airlines()->sync($request->airlines);
        }

        return response()->json($airport->load('country', 'airlines', 'position'));
    }

    /**
     * @OA\Delete(
     *     path="/api/airports/{id}",
     *     summary="Delete an airport",
     *     tags={"Airport"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airport deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     )
     * )
     */
    public function deleteAirport(int $id): JsonResponse
    {
        $airport = Airport::with('country', 'airlines', 'position')->find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        $airport->delete();

        return response()->json(['message' => 'Airport deleted successfully'], 200);
    }
}
