<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Country",
 *   type="object",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Country ID"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Country name"
 *   ),
 *   @OA\Property(
 *     property="code",
 *     type="string",
 *     description="Country code"
 *   )
 * )
 */
class Country
{
}
