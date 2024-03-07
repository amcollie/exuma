<?php

declare(strict_types=1);

namespace Exuma\Router;

use Exception;

class Router implements RouterInterface
{
    /**
     * array of routes
     * @var array
     */
    protected array $routes = [];
    
    /**
     * array of route params
     * @var array
     */
    protected array $params = [];
    
    /**
     * add suffix to controller name
     * @var string
     */
    protected string $controllerSuffix = 'controller';
    
    /**
     * @inheritDoc
     */
    public function add(string $route, array $params): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformToPascalCase($controllerString);
            $controllerString = $this->getNamespace();
            
            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params['action'];
                $action = $this->transformCamelCase($action);
                
                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->action();
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    }

    /**
     * match the route to the routes in the routing table,
     * setting the $this->@params property if the route
     * is found
     *
     * @param string $url
     * @return bool
     */
    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * converts string to Pascal Case
     * @param string $string
     * @return string
     */
    private function transformToPascalCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    
    /**
     * Get the namespace for the controller class defined
     * in the route @parameters only if it was added
     *
     * @return string
     */
    private function getNamespace(): string
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        
        return $namespace;
    }

    private function transformCamelCase(string $string): string
    {
        return lcfirst($this->transformToPascalCase($string));
    }
}