<?php

class CheckServer
{

    private bool $isServer = false;

    function server_or_cli()
    {
        if (php_sapi_name() === "cli") {
            echo ("\nRunning from CLI\n");
            $this->isServer = false;
        } else {
            $this->isServer = true;
            echo ("\nNot Running from CLI\n");
        }
        return $this->isServer;
    }
}
