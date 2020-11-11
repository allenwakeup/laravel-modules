<?php

namespace Goodcatch\Modules\Laravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;

class LocalizationViewPath extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $path = '') {

        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $currentLocale = app('laravellocalization')->getCurrentLocale();
        if (! empty ($path))
        {
            $path = trim ($path, '/') . '/';
        }
        $viewPath = resource_path('views/' . $path . $currentLocale);

        // Add current locale-code to view-paths
        View::addLocation($viewPath);

        return $next($request);
    }
}
