<?php

use App\Framework\Cli\Commands\Socket;
use App\Framework\Cli\Commands\Serve;
use App\Framework\Config\_Global;

require_once __DIR__.'/../../vendor/autoload.php';

final class ExeCommand
{
    private $global;

    public function __construct()
    {
        $data = require __DIR__.'/../../Global.php';
        $this->global = new _Global($data);
    }

    private $commands = [
        'socket'=> Socket::class,
        'serve'=> Serve::class,
    ];

    public function call($command, $args)
    {
        if (isset($this->commands[$command])) {
            (new ($this->commands[$command])($this->global, $args))->validate()->run();
        } else {
            echo 'Invalid Command';
        }
    }
}

return new ExeCommand();
