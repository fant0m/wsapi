<?php
namespace core;

use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Class Autowire
 * @package core
 */
class Autowire
{
    private static $instance;
    private $container;

    private function __construct()
    {
        $this->container = [];
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
     * Set class injection rule
     * @param string $origin
     * @param string $destination
     * @throws Exception
     */
    public function set(string $origin, string $destination): void
    {
        // check if class exists
        if (!class_exists($destination)) {
            throw new Exception('Class ' . $destination . ' was not found!');
        }

        $this->container[$origin] = $destination;
    }

    /**
     * Get class injection rule
     * @param string $origin
     * @return string|null
     */
    private function get(string $origin): ?string
    {
        return $this->container[$origin] ?? null;
    }

    /**
     * Resolve class
     * @param string $class
     * @param string|null $method
     * @return object
     * @throws ReflectionException
     */
    public function resolve(string $class, string $method = null): object
    {
        // check if class doesn't have configured class for injection
        $inject = $this->get($class);
        if ($inject) {
            $class = $inject;
        }

        // check if class exists
        if (!class_exists($class)) {
            throw new Exception('Class ' . $class . ' was not found!');
        }

        // init reflection
        $r = new ReflectionClass($class);

        // check if class method exists
        if ($method && !$r->hasMethod($method)) {
            throw new Exception('Method ' . $method . ' was not found!');
        }

        // check if class has any constructor
        $constructor = $r->getConstructor();
        if (!$constructor) {
            return $r->newInstance();
        }

        // access constructor's params
        $params = $constructor->getParameters();
        $args = [];

        // if there are not any params create new instance; otherwise resolve them before instantiating
        if (count($params) > 0) {
            foreach ($params as $param) {
                if (!$param->isOptional()) {
                    $args[] = $this->resolve($param->getClass()->getName());
                }
            }

            return $r->newInstanceArgs($args);
        } else {
            return $r->newInstance();
        }
    }
}
