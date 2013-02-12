<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path'    => array(__DIR__.'/../templates'),
    'twig.options' => array('cache' => __DIR__.'/../cache'),
    ));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
}));

use Mparaiso\Provider\DoctrineORMServiceProvider;
use Mparaiso\Doctrine\ORM\Logger\MonologSQLLogger;

$app->register(new DoctrineORMServiceProvider(),array(
    "em.options"=>array(
        "host"=>getenv("SILEX_VIDEO_HOST"),
        "dbname"=>getenv("SILEX_VIDEO_DB"),
        "user"=>getenv("SILEX_VIDEO_USER"),
        "password"=>getenv("SILEX_VIDEO_PASSWORD"),
        "driver"=>"pdo_mysql"
        ),
    "em.logger"=>function($app){
        return new MonologSQLLogger($app["logger"]);
    },
    "em.proxy_dir"=>dirname(__DIR__)."/cache",
    "em.is_dev_mode"=>$app["debug"],
    "em.metadata"=>array(
        "type"=>"yaml",
        "path"=>array(__DIR__."/Video/Entities/")
        ),
    )
);

return $app;
