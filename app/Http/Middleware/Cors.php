<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Middleware que trata o CORS.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->getMethod() == 'OPTIONS') {
            $headers = [
                'Access-Control-Allow-Origin' => config('cors.allowed_origins'),
                'Access-Control-Allow-Methods' => implode(',', getRouteInformationsByGroup('methods')),
                'Access-Control-Allow-Headers' => config('cors.allowed_headers'),
                'Access-Control-Expose-Headers' => config('cors.exposed_headers'),
                'Access-Control-Allow-CredentialsHeaders' => config('cors.supports_credentials'),
                'Max-Age' => config('cors.max_age'),
            ];

            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
        }

        return $response;
    }
}
