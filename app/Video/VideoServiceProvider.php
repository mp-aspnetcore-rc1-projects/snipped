<?php
namespace Video;
/**
 * Configuration
 */
use Silex\Application;
use Silex\ServiceProviderInterface;

class VideoServiceProvider implements ServiceProviderInterface{

    function register(Application $app){
        $app["video"]=array("title"=>"Silex Video");
    }

    function boot(Application $app){

    }
}