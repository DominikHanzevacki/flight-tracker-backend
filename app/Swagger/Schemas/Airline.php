<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Airline",
 *   type="object",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Airline ID"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Airline name"
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
 *   )
 * )
 */
class Airline
{
}
