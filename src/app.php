<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Application();
$app["debug"] = true;
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
        "path"=>array(dirname(__DIR__)."/config/entities/")
        ),
    )
);
//@note @sulex utiliser un fichier yaml pour la configuration des routes
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

$app['routes'] = $app->share($app->extend('routes',function($routes,$app){
    $loader = new YamlFileLoader(new FileLocator(__DIR__.'/../config/routing/'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
    return $routes;
}));

return $app;
