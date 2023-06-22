<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class RouteHelper
{

    public static function loadRouteFiles($folder)
    {

        //* checking to see if the route files has been cached already
        if (Cache::has('route_files')) {
            $routeFiles = Cache::get('route_files');
        } else {
            $routeFiles = glob($folder . '/*.php');
            Cache::put('route_files', $routeFiles, 3600);
        }

        //* Fetch the route files
        foreach ($routeFiles as $file) {
            require $file;
        }
    }
}
