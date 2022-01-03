<?php

namespace ProtoneMedia\LaravelViewi\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelViewi\ViewiRequestHandler;
use Viewi\App;
use Viewi\BaseComponent;
use Viewi\Routing\Route as ViewiRoute;

class ViewiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->shouldBeHandledByViewi($request)) {
            return $next($request);
        }

        $this->initializeViewi();

        /** @var Route $route */
        $route = $request->route();

        /** @var BaseComponent $component */
        $component = $route->controller;

        if (method_exists($component, '__init')) {
            app()->call([$component, '__init'], $route->parameters());
        }

        $route->controller = new ViewiRequestHandler($component);

        return $next($request);
    }

    /**
     * Returns a boolean whether this route should be handled by Viewi.
     *
     * @param \Illuminate\Http\Request $request
     * @return boolean
     */
    private function shouldBeHandledByViewi(Request $request): bool
    {
        $route = $request->route();

        if (!$route instanceof Route) {
            return false;
        }

        if (!$route->controller instanceof BaseComponent) {
            return false;
        }

        return true;
    }

    /**
     * Initializes the Viewi app and registers the routes.
     *
     * @return void
     */
    private function initializeViewi()
    {
        App::init(config('viewi'));

        $this->addRoutesToViewi(LaravelRoute::getRoutes()->getRoutes());
    }

    /**
     * Loops through the Laravel routes and adds them to the Viewi router.
     *
     * @param array $routes
     * @return void
     */
    private function addRoutesToViewi(array $routes)
    {
        Collection::make($routes)->filter(function (Route $route) {
            if ($route->controller) {
                return $route->controller instanceof BaseComponent;
            }

            $action = $route->action['controller'] ?? null;

            if (Str::contains($action, '@')) {
                return false;
            }

            return app($action) instanceof BaseComponent;
        })->each(function (Route $route) {
            foreach ($route->methods() as $method) {
                ViewiRoute::add(
                    $method,
                    $route->uri(),
                    $route->action['controller']
                );
            }
        });
    }
}
