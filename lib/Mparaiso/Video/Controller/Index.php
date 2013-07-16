<?php
namespace Mparaiso\Video\Controller;

use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Index implements ControllerProviderInterface
{
    function index(Request $req, Application $app)
    {
        $videos = $app["video.service.video"]->findBy(array("favorite" => true));
        return $app["twig"]->render("video/index.html.twig", array("videos" => $videos));
    }

    function read(Request $req, Application $app, $id)
    {
        $video = $app["video.service.video"]->find($id);
        $video_next = $app["video.service.video"]->findNext($video);
        $video_previous = $app["video.service.video"]->findPrevious($video);
        return $app["twig"]->render("video/read.html.twig", array(
            "video" => $video,
            "video_next" => array_pop($video_next),
            "video_previous" => array_pop($video_previous),
        ));
    }

    function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];

        /* @var \Silex\ControllerCollection $controllers */

        $controllers->match("/", array($this, "index"))
            ->bind("mp_video_index");
        $controllers->match("/{id}/{name}", array($this, "read"))
            ->value("name", null)
            ->assert("id", '\d+')
            ->bind("mp_video_read");


        return $controllers;
    }
}

