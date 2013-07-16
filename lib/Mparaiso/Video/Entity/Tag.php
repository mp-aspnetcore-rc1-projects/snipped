<?php

namespace Mparaiso\Video\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @Table(name="mp_video_tags")
 *
 */
class Tag
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var integer
     */
    protected $id;
    /**
     * @Column(type="string",length=50)
     * @var string
     */
    protected $title;

    /**
     * @ManyToMany(targetEntity="\Mparaiso\Video\Entity\Video")
     * @var ArrayCollection[Video]
     */
    protected $videos;

    function __construct()
    {
        $this->videos = new ArrayCollection;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    function __toString()
    {
        return $this->title;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }

    function addVideo(Video $video)
    {
        $this->videos[] = $video;
    }


    function removeVideo(Video $video)
    {
        $this->videos->remove($video);
    }
}


