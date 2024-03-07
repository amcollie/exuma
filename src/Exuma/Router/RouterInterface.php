<?php

declare(strict_types=1);

namespace Exuma\Router;

interface RouterInterface
{
    /**
     * Add Route to the routing table
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add(string $route, array $params): void;
    
    /**
     * Dispatch route and create controller objects
     * and execute the default method on the controller
     * object
     *
     * @param string $url
     * @return void
     */
    public function dispatch(string $url): void;
}