<?php
/**
 * Configuration
 */
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Mparaiso\Provider\DoctrineORMServiceProvider;
use Mparaiso\Video\Provider\VideoServiceProvider;
use Silex\Provider\TwigServiceProvider;

class Config implements Silex\ServiceProviderInterface
{

    function register(Application $app)
    {
        // FR: configure Twig
        $app->register(new TwigServiceProvider, array(
            "twig.path" => __DIR__ . "/Resources/views",
            "twig.options" => array(
                "cache" => __DIR__ . "/../temp/twig",
            )
        ));

        // FR: configure doctrine DBAL
        $app->register(new DoctrineServiceProvider, array(
            "db.config" => array(
                "driver"=>getenv("VIDEO_DRIVER"),
                "host"=>getenv("VIDEO_HOST"),
                "user"=>getenv("VIDEO_USER"),
                "password"=>getenv("VIDEO_PASSWORD"),
                "database"=>getenv("VIDEO_DB")
            )
        ));
        // FR : configure doctrine ORM
        $app->register(new DoctrineOrmServiceProvider, array(
            "orm.proxy_dir" => __DIR__ . "/Proxy",
            "orm.driver.configs" => array(
                "default" => array(
                    "paths" => array(__DIR__ . '\..\lib\Mparaiso\Video\Entity'),
                    "type" => "annotation",
                    "namespace" => '\Mparaiso\Video\Entity'
                )
            )
        ));

        $app->register(new VideoServiceProvider);
    }

    function boot(Application $app)
    {
        // homepage
        $app->match("/", function (Application $app) {
            return $app["twig"]->render("index.html.twig", array(
                "message" => "Hello Silex Video"));
        });
    }
}