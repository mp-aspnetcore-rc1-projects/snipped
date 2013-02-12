<?php

namespace Video\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class VideoController{
    function index(Application $app,Request $req){
        return $app["twig"]->render("video_index.html.twig",array());
    }
    function create(){
        return;
    }
    function getById($id,Application $app){
        return $app["twig"]->render("video.html.twig",array("id"=>$id));
    }
    function getByTitle($title,Application $app){
        return $app["twig"]->render("video.html.twig",array("title"=>$title));
    }
}