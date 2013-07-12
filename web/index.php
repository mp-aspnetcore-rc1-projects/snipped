<?php

$autoload = require(__DIR__."/../vendor/autoload.php");

$app = new App(array("debug"=>TRUE));

$app->run();