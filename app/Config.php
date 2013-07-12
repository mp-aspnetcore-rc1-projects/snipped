<?php
/**
 * Configuration
 */
use Silex\Application;

class Config implements Silex\ServiceProviderInterface{

    function register(Application $app){

    }

    function boot(Application $app){
        $app->get("/",function(){
            return "Hello Silex Video";
        });
    }
}