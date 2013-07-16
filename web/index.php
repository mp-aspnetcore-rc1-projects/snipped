<?php

error_reporting(E_ALL);

$autoload = require(__DIR__ . "/../vendor/autoload.php");

$app = new App(array("debug" => true));

$app->run();