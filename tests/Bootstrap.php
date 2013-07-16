<?php

$autoload = require __DIR__ . "/../vendor/autoload.php";

$autoload->add("", __DIR__ . "/../tests");

class Bootstrap
{
    static function getApp()
    {
        $app = new App;
        $app["session.test"]=true;
        $app->boot();
        return $app;
    }
}