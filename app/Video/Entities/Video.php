<?php

namespace Video\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 */
class Video
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $screenshot_url;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var string
     */
    private $oneToMany;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set screenshot_url
     *
     * @param string $screenshotUrl
     * @return Video
     */
    public function setScreenshotUrl($screenshotUrl)
    {
        $this->screenshot_url = $screenshotUrl;
    
        return $this;
    }

    /**
     * Get screenshot_url
     *
     * @return string 
     */
    public function getScreenshotUrl()
    {
        return $this->screenshot_url;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Video
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set oneToMany
     *
     * @param string $oneToMany
     * @return Video
     */
    public function setOneToMany($oneToMany)
    {
        $this->oneToMany = $oneToMany;
    
        return $this;
    }

    /**
     * Get oneToMany
     *
     * @return string 
     */
    public function getOneToMany()
    {
        return $this->oneToMany;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tags
     *
     * @param \Video\Entities\Tag $tags
     * @return Video
     */
    public function addTag(\Video\Entities\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Video\Entities\Tag $tags
     */
    public function removeTag(\Video\Entities\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}