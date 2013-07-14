<?php

namespace Mparaiso\Video\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;


class Base implements ObjectRepository
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    /**
     * @var
     */
    protected $className;

    function __construct(EntityManager $em, $className)
    {
        $this->em = $em;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    function find($id)
    {
        return $this->em->find($this->className, $id);
    }

    /**
     * {@inheritdoc}
     */
    function findAll()
    {
        return $this->em->getRepository($this->className)->findAll();
    }

    /**
     * {@inheritdoc}
     */
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->em->getRepository($this->className)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    function findOneBy(array $criteria, array $orderBy = array())
    {
        return $this->em->getRepository($this->className)->findOneBy($criteria, $orderBy);
    }


    function delete($model, $flush = true)
    {
        $this->em->remove($model);
        if ($flush) {
            $this->em->flush();
        }
    }

    function save($model, $flush = true)
    {
        $this->em->persist($model);
        if ($flush==true) {
            $this->em->flush($model);
        }
    }

    function count()
    {
        $query = $this->em->createQuery("select count(v) FROM $this->className v");
        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    function getClassName()
    {
        return $this->className;
    }
}