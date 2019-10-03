<?php
namespace core;

/**
 * Class Route
 * @package core
 */
class Route
{
    private $action;
    private $method;
    private $controllerName;
    private $controllerMethod;

    // @todo support proper route url

    public const ACTION_DEFAULT = '';
    public const ACTION_NOT_FOUND = '*';

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    /**
     * Route constructor.
     * @param string $action
     * @param string $method
     * @param string $controllerName
     * @param string $controllerMethod
     */
    public function __construct(string $action, string $method, string $controllerName, string $controllerMethod)
    {
        $this->action = $action;
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return string
     */
    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    /**
     * @param string $controllerMethod
     */
    public function setControllerMethod(string $controllerMethod): void
    {
        $this->controllerMethod = $controllerMethod;
    }
}
