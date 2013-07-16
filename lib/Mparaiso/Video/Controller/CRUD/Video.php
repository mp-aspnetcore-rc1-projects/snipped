<?php

namespace Mparaiso\Video\Controller\CRUD;

use Mparaiso\CodeGeneration\Controller\CRUD;

class Video extends CRUD
{
    function bulkFavorite($ids, $app)
    {
        foreach ($ids as $id) {
            $video = $app["video.service.video"]->find($id);
            /* @var \Mparaiso\Video\Entity\Video $video */
            $video->setFavorite(true);
            $app["video.service.video"]->save($video);
        }
        return true;
    }
}
