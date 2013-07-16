<?php
/**
 * Configuration
 */
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Mparaiso\Provider\VideoServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Monolog\Handler\Mongo;
use Silex\Provider\UrlGeneratorServiceProvider;
use Mparaiso\Provider\CrudServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\FormServiceProvider;
use Mparaiso\Provider\ConsoleServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Mparaiso\Provider\DoctrineORMServiceProvider;
use Silex\Provider\TwigServiceProvider;

class Config implements Silex\ServiceProviderInterface
{

    function register(Application $app)
    {
        // controllers as services
        $app->register(new ServiceControllerServiceProvider);
        $app->register(new SessionServiceProvider);
        $app->register(new ConsoleServiceProvider);
        // FR: configure Twig
        $app->register(new TwigServiceProvider, array(
            "twig.path" => __DIR__ . "/Resources/views",
            "twig.options" => array(
                "cache" => __DIR__ . "/../temp/twig",
            )
        ));

        $app->register(new MonologServiceProvider, array(
            "monolog.logfile" => __DIR__ . "/../temp/log/log-" . date("Y-m-d") . ".txt"
        ));

        $app->register(new FormServiceProvider);

        $app->register(new TranslationServiceProvider);

        $app->register(new ValidatorServiceProvider);

        $app->register(new UrlGeneratorServiceProvider);

        // FR: configure doctrine DBAL
        $app->register(new DoctrineServiceProvider, array(
            "db.options" => array(
                "driver" => getenv("VIDEO_DRIVER"),
                "host" => getenv("VIDEO_HOST"),
                "user" => getenv("VIDEO_USER"),
                "password" => getenv("VIDEO_PASSWORD"),
                "dbname" => getenv("VIDEO_DB")
            )
        ));
        // FR : configure doctrine ORM
        $app->register(new DoctrineOrmServiceProvider, array(
            "orm.proxy_dir" => __DIR__ . "/Proxy",
            "orm.driver.configs" => array(
                "default" => array(
                    "paths" => array(__DIR__ . '/../lib/Mparaiso/Video/Entity'),
                    "type" => "annotation",
                    "namespace" => 'Mparaiso\Video\Entity'
                )
            )
        ));
        $app->register(new CrudServiceProvider);
        $app->register(new VideoServiceProvider);
    }

    function boot(Application $app)
    {


        // homepage
//        $app->match("/", function (Application $app) {
//            return $app["twig"]->render("index.html.twig", array(
//                "message" => "Hello Silex Video"));
//        });
    }
}