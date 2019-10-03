<?php
namespace core;

use Exception;

/**
 * Class Router
 * @package core
 */
class Router
{
    private static $instance;
    private $routes;
    private $url;
    private $route;

    private function __construct()
    {
        $this->routes = [];
    }

    /**
     * Get singleton instance
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Add new route
     * @param string $method
     * @param string $action
     * @param string $controllerName
     * @param string $controllerMethod
     */
    public function add(string $method, string $action, string $controllerName, string $controllerMethod): void
    {
        $this->routes[] = new Route($action, $method, $controllerName, $controllerMethod);
    }

    /**
     * Add new GET route
     * @param string $action
     * @param string $controllerName
     * @param string $controllerMethod
     */
    public function get(string $action, string $controllerName, string $controllerMethod): void
    {
        $this->add(Route::METHOD_GET, $action, $controllerName, $controllerMethod);
    }

    /**
     * Add new POST route
     * @param string $action
     * @param string $controllerName
     * @param string $controllerMethod
     */
    public function post(string $action, string $controllerName, string $controllerMethod): void
    {
        $this->add(Route::METHOD_POST, $action, $controllerName, $controllerMethod);
    }

    /**
     * Display required page
     * @return string
     * @throws Exception
     */
    public function dispatch(): string
    {
        // access current url properties
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? Route::ACTION_DEFAULT;

        // currently we do support just simple url /, anything else is invalid request
        if ($this->url[-1] !== '/') {
            $action = Route::ACTION_NOT_FOUND;
        }

        // try to match the action
        $this->route = $this->findRoute($action, $method);

        // action wasn't found so we return blank page
        if (!$this->route) {
            return '';
        }

        // access route data
        $controllerName = 'controller\\' . $this->route->getControllerName();
        $methodName = $this->route->getControllerMethod();

        // load controller
        $controller = Autowire::getInstance()->resolve($controllerName, $methodName);

        // call method
        return $controller->$methodName();
    }

    /**
     * Try to find any route matching desired action and method
     * @param string $action
     * @param string $method
     * @return Route|null
     */
    private function findRoute(string $action, string $method): ?Route
    {
        // try to find desired or not found action
        $routes = array_values(array_filter(
            $this->routes,
            function (Route $route) use ($action, $method) {
                return ($route->getAction() === $action || $route->getAction() === Route::ACTION_NOT_FOUND)
                    && $route->getMethod() == $method;
            }
        ));

        if (count($routes) == 0) {
            // route was not found
            return null;
        } else if (count($routes) == 1) {
            // exact route was found
            return $routes[0];
        } else {
            // both not found and desired action were found so we display the desired one
            return $routes[0]->getAction() == Route::ACTION_NOT_FOUND ? $routes[1] : $routes[0];
        }
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->route ? $this->route->getAction() : null;
    }
}
