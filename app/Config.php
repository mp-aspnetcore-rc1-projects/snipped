<?php
/**
 * Configuration
 */
use Silex\Application;
use Video\VideoServiceProvider;
use Silex\Provider\TwigServiceProvider;
class Config implements Silex\ServiceProviderInterface{

    function register(Application $app){

        $app->register(new TwigServiceProvider,array(
            "twig.path"=>__DIR__."/Resources/views",
            "twig.options"=>array(
                "cache"=>__DIR__."/../temp/twig",
                )
            ));

        $app->register(new VideoServiceProvider);
    }

    function boot(Application $app){
        // homepage
        $app->match("/",function(Application $app){
            return $app["twig"]->render("index.html.twig",array(
                "message"=>"Hello Silex Video"));
        });
    }
}