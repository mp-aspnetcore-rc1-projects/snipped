<?php

namespace Mparaiso\Video\Service;

use Doctrine\Common\Collections\ExpressionBuilder;
use Mparaiso\Video\Entity\Video as VideoEntity;

class Video extends Base
{
    function findNext(VideoEntity $video, $field = "created")
    {
        $eb = new ExpressionBuilder();
        $qb = $this->em->createQueryBuilder()->select("v")->from($this->className, "v");
        $qb->where("v.id > :id ")->setParameter("id", $video->getId())->orderBy("v.id", "DESC");
        return $qb->getQuery()->getResult();
    }

    function findPrevious(VideoEntity $video, $field = "created")
    {
        $eb = new ExpressionBuilder();
        $qb = $this->em->createQueryBuilder()->select("v")->from($this->className, "v");
        $qb->where("v.id < :id")->setParameter("id", $video->getId())->orderBy("v.id", "ASC");
        return $qb->getQuery()->getResult();
    }
}
