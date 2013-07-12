<?php
/**
 * Configure the video app
 */
namespace Mparaiso\Video\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;

class VideoServiceProvider implements ServiceProviderInterface
{
    function register(Application $app)
    {
        $app['video'] = array("title" => "Silex Video");

    }

    function boot(Application $app)
    {
        
    }
}