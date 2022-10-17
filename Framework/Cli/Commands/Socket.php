<?php

namespace App\Framework\Cli\Commands;

use App\Framework\Config\_Global;
use Ratchet\App;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Framework\RouteLoader\FileLoader;
use App\Framework\RouteLoader\RouteCollector;

final class Socket
{

    private $settings;

    public function __construct(_Global $global)
    {
        $this->settings = $global;
    }

    public function validateArgs($argv){

    }

    public function parseArgs($argv){

    }

    public function run($argv)
    {
        $settings = $this->settings->get('socket');
        $app = new \Ratchet\App($settings['host'], $settings['port']);


        $path = __DIR__ ;
        $path = dirname($path, 3) . '\\Modules\\Socket\\';
        $fileLoader = new FileLoader([$path]);
        if (empty($fileLoader)) return;
        $classMethods = RouteCollector::findClassMethods($fileLoader->getFiles());
        if (empty($classMethods)) return;
        foreach ($classMethods as $methodName => $classMethod)
        {
            $routePattern = $classMethod->getRoutePattern();
            $className = explode(':',$classMethod->getMethodName())[0];
            $app->route($routePattern, new ($className), array('*'));
        }

        $app->run();
    }
}
