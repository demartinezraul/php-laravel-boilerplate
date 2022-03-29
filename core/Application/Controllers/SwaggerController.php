<?php

namespace Core\Application\Controllers;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    /**
     * @OA\Info(
     *      version="1",
     *      title="Aplicacao Laravel - DDD - Swagger.",
     *      description="Documentação da aplicação Laravel -  DDD -Swagger"
     * )
     *
     * @OA\Server(
     *      url=API_BASE_URL,
     *      @OA\ServerVariable(
     *          serverVariable="schema",
     *          enum={"https", "http"},
     *          default="http"
     *      )
     * )
     *
     * @OA\SecurityScheme(
     *     type="oauth2",
     *     description="",
     *     name="Password Based",
     *     in="header",
     *     scheme="https",
     *     securityScheme="Password Based",
     *     @OA\Flow(
     *         flow="password",
     *         authorizationUrl="/oauth/authorize",
     *         tokenUrl="/oauth/token",
     *         refreshUrl="/oauth/token/refresh",
     *         scopes={}
     *     )
     * )
     */
}
