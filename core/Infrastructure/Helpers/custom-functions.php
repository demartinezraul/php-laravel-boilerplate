<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RoutingRoute;

define('API_BASE_URL', env('APP_URL'));

if (!function_exists('example_function')) {
    function example_function($params): void
    {
        throw new LogicException($params);
    }
}

if (!function_exists('getFileListSuggestion')) {
    function getFileListSuggestion(string $layername = null): array
    {
        $commandFileList = [
            'Application' => [
                'ApiController',
                'Interface',
                'ServiceInterface',
                'Service',
                'Command',
                'DTO',
                'RequestDTO',
                'IntegrationDTO',
                'ResponseDTO',
            ],
            'Domain' => [
                'Interface',
                'Entity',
                'Exception',
                'ServiceInterface',
                'Service',
                'Enum',
                'Event',
                'HttpClientInterface',
                'RepositoryInterface',
                'SpecificationInterface',
                'Specification',
                'SpecificationRule',
                'ValueObject',
            ],
            'Infrastructure' => [
                'Eloquent',
                'Helper',
                'HttpClient',
                'Mapper',
                'Repository',
            ],
        ];

        return array_key_exists($layername, $commandFileList) ? $commandFileList[$layername] : '';
    }
}

if (!function_exists('getLayersListSuggestion')) {
    function getLayersListSuggestion(): array
    {
        return [
            'Application',
            'Domain',
            'Infrastructure',
        ];
    }
}

if (!function_exists('getRouteInformationsByGroup')) {

    /**
     * Get route information by current route group.
     *
     * @param string $indexToReturn - methods|endpoints
     * @return string
     */
    function getRouteInformationsByGroup(string $indexToReturn = 'methods'): array
    {
        $resourceOptionsAvaiable = [];
        $allRoutes = array_map(function (RoutingRoute $route) {
            return $route;
        }, (array)Route::getRoutes()->getIterator());

        $groupedRoutes = array_filter($allRoutes, function ($route) {
            $action = $route->getAction();

            if (isset($action['prefix'])) {
                $groupPrefix = request()->route()->action['prefix'];

                if (is_array($action['prefix'])) {
                    return in_array($groupPrefix, $action['prefix']);
                } else {
                    return $action['prefix'] == $groupPrefix;
                }
            }

            return false;
        });

        $resourceOptionsAvaiable['methods'] = [];
        $resourceOptionsAvaiable['endpoints'] = [];

        foreach ($groupedRoutes as $route) {
            $resourceOptionsAvaiable['methods'][] = implode(',', $route->methods);
            $resourceOptionsAvaiable['methods'] = str_replace(',HEAD', '', $resourceOptionsAvaiable['methods']);
            $resourceOptionsAvaiable['methods'] = array_unique($resourceOptionsAvaiable['methods']);

            $resourceOptionsAvaiable['endpoints'][] = $route->uri;
        }

        return $resourceOptionsAvaiable[$indexToReturn];
    }
}
