<?php
namespace App\Core;

/**
 * RESTful MVC Router with Middleware Support
 */
class Router
{
    private static array $routes = [];

    public static function get(string $path, array|callable $callback, array $middlewares = []): void
    {
        self::addRoute('GET', $path, $callback, $middlewares);
    }

    public static function post(string $path, array|callable $callback, array $middlewares = []): void
    {
        self::addRoute('POST', $path, $callback, $middlewares);
    }

    private static function addRoute(string $method, string $path, array|callable $callback, array $middlewares): void
    {
        $path = '/' . trim($path, '/');
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public static function resolve(): void
    {
        $method = Request::getMethod();
        $path = Request::getUri();

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Convert route pattern to regex for dynamic parameters like {id}
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match

                // Execute Middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareInstance = new $middleware();
                    if (!$middlewareInstance->handle()) {
                        return; // Middleware aborted execution
                    }
                }

                $callback = $route['callback'];

                if (is_callable($callback)) {
                    call_user_func_array($callback, $matches);
                    return;
                }

                if (is_array($callback)) {
                    [$controllerClass, $action] = $callback;
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            call_user_func_array([$controller, $action], $matches);
                            return;
                        }
                    }
                }
            }
        }

        // 404 Route Not Found fallback
        Response::setStatusCode(404);
        $controller = new \App\Controllers\PageController();
        $controller->notFound();
    }
}
