<?php

/**
 * FR : Configuration de l'application console
 */
$autoload = require(__DIR__ . "/vendor/autoload.php");

$app = new App(array("debug"=>true));

$app->boot();

$console = $app["console"];

// booting doctrine orm commands;
$app['orm.console.boot_commands']();

$console->run();