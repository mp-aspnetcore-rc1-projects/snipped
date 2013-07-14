<?php

namespace Mparaiso\Video\Entity;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Article
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var integer
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $content;

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
     * @ManyToOne(targetEntity="Mparaiso\Video\Entity\Category",inversedBy="articles",cascade={"persist"})
     */
    protected $category;

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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    function __toString()
    {
        return $this->title;
    }

    /**
     * @PrePersist
     */
    function prepersist()
    {
        if ($this->created == null) {
            $this->created = new \DateTime;
        }
        $this->updated = new \DateTime;
    }
}
