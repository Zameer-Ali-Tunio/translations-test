<?php

namespace App\Http\Controllers\API;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Translation Service API",
 *     description="API documentation for managing translations.",
 *     @OA\Contact(
 *         email="youremail@example.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Use a valid bearer token to access protected routes",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="sanctum"
 * )
 */
class SwaggerController
{
    // This file only holds OpenAPI annotations
}
