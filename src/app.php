<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SessionServiceProvider;

use Silex\Provider\WebProfilerServiceProvider;

$app = new Application();
$app["debug"] = true;


// $app->register($p = new WebProfilerServiceProvider(), array(
//     'profiler.cache_dir' => __DIR__.'/../cache/profiler',
// ));
// $app->mount('/_profiler', $p);


$app->register(new SessionServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path'    => array(__DIR__.'/../templates'),
    'twig.options' => array('cache' => __DIR__.'/../cache'),
    ));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // add custom globals, filters, tags, ...
    //$twig->addExtension(new AsseticExtension($app["assetic"],$app["debug"]));
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
# CHARGEMENT DES ROUTES VIA FICHIER DE CONFIGURATION YML
//@note @sulex utiliser un fichier yaml pour la configuration des routes
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

$app['routes'] = $app->share($app->extend('routes',function($routes,$app){
    $loader = new YamlFileLoader(new FileLocator(__DIR__.'/../config/routing/'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
    return $routes;
}));
use Symfony\Component\Validator\Mapping\Cache\ApcCache;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\YamlFileLoader as ValidatorYamlFileLoader;
# CHARGEMENT DES CONSTRAINTES DE VALIDATION VIA DES FICHIERS DE CONFIGURATION YML
$app["validator.mapping.class_metadata_factory"]=$app->share(function($app){
    $cache = new ApcCache("validation_");
    $loader = new ValidatorYamlFileLoader(dirname(__DIR__)."/config/validation/validation.yml");
    return new ClassMetadataFactory($loader,$cache);
});

return $app;
