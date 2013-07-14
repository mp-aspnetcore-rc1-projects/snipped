<?php
/**
 * Configure the video app
 */
namespace Mparaiso\Provider;

use Silex\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Mparaiso\CodeGeneration\Controller\CRUD;
use Mparaiso\Video\Service\Base;
use Silex\Application;
use Twig_Loader_Filesystem;

class VideoServiceProvider implements ServiceProviderInterface
{
    function register(Application $app)
    {
        $app['video'] = array("title" => "Silex Video");

        // Models and Entities
        $app['video.model.video'] = '\Mparaiso\Video\Entity\Video';
        $app['video.model.playlist'] = '\Mparaiso\Video\Entity\Playlist';
        $app['video.model.playlistVideo'] = '\Mparaiso\Video\Entity\PlaylistVideo';
        $app['video.model.tag'] = '\Mparaiso\Video\Entity\Tag';
        $app['video.model.client'] = '\Mparaiso\Video\Entity\Client';
        $app['video.model.category'] = '\Mparaiso\Video\Entity\Category';
        $app['video.model.article'] = '\Mparaiso\Video\Entity\Article';
        // forms
        $app['video.form.video'] = '\Mparaiso\Video\Form\Video';
        $app['video.form.playlist'] = '\Mparaiso\Video\Form\Playlist';
        $app['video.form.playlistVideo'] = '\Mparaiso\Video\Form\PlaylistVideo';
        $app['video.form.tag'] = '\Mparaiso\Video\Form\Tag';
        $app['video.form.client'] = '\Mparaiso\Video\Form\Client';
        $app['video.form.category'] = '\Mparaiso\Video\Form\Category';
        $app['video.form.article'] = '\Mparaiso\Video\Form\Article';

        // services , allow controllers to access data stored in databases
        $app['video.service.video'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.video']);
        });
        $app['video.service.playlist'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.playlist']);
        });
        $app['video.service.playlistVideo'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.playlistVideo']);
        });
        $app['video.service.tag'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.tag']);
        });
        $app['video.service.client'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.client']);
        });
        $app['video.service.article'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.article']);
        });
        $app['video.service.category'] = $app->share(function ($app) {
            return new Base($app['orm.em'], $app['video.model.category']);
        });
        // controllers
        // ADMIN CRUD Controllers
        $app['video.crud.params.templateLayout'] = "video/crud.layout.html.twig";
        $app['video.crud.controller.video'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.video"],
                "formClass" => $app['video.form.video'],
                "service" => $app["video.service.video"],
                "resourceName" => "video",
                "propertyList" => array('id', 'title', "favorite"),
                "orderList" => array("id", "title", "created_at", 'favorite'),
                "templateLayout" => $app['video.crud.params.templateLayout'],
                "formTemplate" => "video/forms/video.html.twig",
            ));
        });
        $app['video.crud.controller.client'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.client"],
                "formClass" => $app['video.form.client'],
                "service" => $app["video.service.client"],
                "resourceName" => "client",
                "propertyList" => array('id', 'name', 'created', "videos"),
                "orderList" => array("id", "name", "updated"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
            ));
        });
        $app['video.crud.controller.playlist'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.playlist"],
                "formClass" => $app['video.form.playlist'],
                "service" => $app["video.service.playlist"],
                "resourceName" => "playlist",
                "propertyList" => array('id', 'title'),
                "orderList" => array("id", "title", "getCreatedAt"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
                "formTemplate" => "video/forms/playlist.html.twig",
            ));
        });

        $app['video.crud.controller.tag'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.tag"],
                "formClass" => $app['video.form.tag'],
                "service" => $app["video.service.tag"],
                "resourceName" => "tag",
                "propertyList" => array('id', 'title'),
                "orderList" => array("id", "title"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
            ));
        });

        $app['video.crud.controller.playlistVideo'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.playlistVideo"],
                "formClass" => $app['video.form.playlistVideo'],
                "service" => $app["video.service.playlistVideo"],
                "resourceName" => "playlistVideo",
                "propertyList" => array('id', 'playlist', "video"),
                "orderList" => array("id", "playlist", "video"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
            ));
        });

        $app['video.crud.controller.article'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.article"],
                "formClass" => $app['video.form.article'],
                "service" => $app["video.service.article"],
                "resourceName" => "article",
                "propertyList" => array('id', 'title', "category", "created"),
                "orderList" => array("id", "title", "category", "created"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
            ));
        });

        $app['video.crud.controller.category'] = $app->share(function ($app) {
            return new CRUD(array(
                "entityClass" => $app["video.model.category"],
                "formClass" => $app['video.form.category'],
                "service" => $app["video.service.category"],
                "resourceName" => "category",
                "propertyList" => array('id', 'title'),
                "orderList" => array("id", "title"),
                "templateLayout" => $app['video.crud.params.templateLayout'],
            ));
        });

        $app['twig.loader.filesystem'] = $app->share($app->extend('twig.loader.filesystem', function ($loader, $app) {
            /* @var Twig_Loader_Filesystem $loader */
            $loader->addPath(__DIR__ . "/../Video/Resources/views/");
            return $loader;
        }));
    }

    function boot(Application $app)
    {


        $app->get("/admin", array($app["video.crud.controller.video"], "index"));
        $app->mount("/admin", $app["video.crud.controller.video"]);
        $app->mount("/admin", $app["video.crud.controller.client"]);
        $app->mount("/admin", $app["video.crud.controller.playlist"]);
        $app->mount("/admin", $app["video.crud.controller.tag"]);
        $app->mount("/admin", $app["video.crud.controller.playlistVideo"]);
        $app->mount("/admin", $app["video.crud.controller.article"]);
        $app->mount("/admin", $app["video.crud.controller.category"]);

        $app->on("client_after_update", function (GenericEvent $ev) use ($app) {
            $client = $ev->getSubject();
            /* @var \Mparaiso\Video\Entity\Client $client */
            foreach ($client->getVideos() as $video) {
                $video->setClient($client);
                $app["video.service.video"]->save($video, false);
            }
            $app["orm.em"]->flush();
        });

    }
}