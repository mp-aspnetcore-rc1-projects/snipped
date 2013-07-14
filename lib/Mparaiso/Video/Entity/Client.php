<?php

namespace Mparaiso\Video\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Mparaiso\Video\Entity\Video;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Client
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var integer
     */
    protected $id;

    /**
     * @Column(type="string",unique=true)
     * @Index
     * @var string
     */
    protected $name;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $updated;

    /**
     * @OneToMany(targetEntity="\Mparaiso\Video\Entity\Video",mappedBy="client",cascade={"persist","merge","detach"})
     * @var ArrayCollection
     */
    protected $videos;

    function __construct()
    {
        $this->videos = new ArrayCollection;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    function __toString()
    {
        return $this->name;
    }


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param Video $video
     */
    public function addVideo(Video $video)
    {
        $video->setClient($this);
        $this->videos[] = $video;
    }

    /**
     * @param Video $video
     */
    public function removeVideo(Video $video)
    {
        $ok = $this->videos->removeElement($video);
        if ($ok) {
            $video->setClient(null);
        }
    }

    /**
     * @PrePersist
     */
    function prePersist()
    {
        if ($this->getCreated() == null)
            $this->setCreated(new \DateTime);
        $this->setUpdated(new \DateTime);
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
}