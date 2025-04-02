<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Airport",
 *   type="object",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Airport ID"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Airport name"
 *   ),
 *   @OA\Property(
 *     property="country",
 *     type="object",
 *     @OA\Property(
 *       property="name",
 *       type="string",
 *       description="Country name"
 *     ),
 *     @OA\Property(
 *       property="code",
 *       type="string",
 *       description="Country code"
 *     )
 *   ),
 *   @OA\Property(
 * *     property="position",
 * *     type="object",
 * *     @OA\Property(property="latitude", type="number", format="float"),
 * *     @OA\Property(property="longitude", type="number", format="float")
 * *   ),
 *   @OA\Property(
 *     property="airlines",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/Airline"),
 *     description="List of airlines associated with the airport"
 *   )
 * )
 */
class Airport
{
}
