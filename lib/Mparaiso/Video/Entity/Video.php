<?php

namespace Mparaiso\Video\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Mparaiso\Video\Entity\PlaylistVideo;

/**
 *
 * @Entity
 * @Table(name="mp_video_videos")
 * @HasLifecycleCallbacks
 *
 */
class Video
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
    protected $title;

    /**
     * @Column(type="string",unique=true)
     * @var string
     */
    protected $link;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $poster_url;

    /**
     * @Column(type="text",length=2000)
     * @var string
     */
    protected $description;

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
     * @ManyToOne(targetEntity="\Mparaiso\Video\Entity\Client",inversedBy="videos",cascade={"persist","merge","detach"})
     * @var Client
     */
    protected $client;

    /**
     * @ManyToMany(targetEntity="\Mparaiso\Video\Entity\Tag",cascade={"all"})
     * @var ArrayCollection
     */
    protected $tags;

    /**
     * @Column(type="boolean",nullable=true)
     * @var boolean
     */
    protected $favorite;


    /**
     * @OneToMany(targetEntity="\Mparaiso\Video\Entity\PlaylistVideo",mappedBy="video",cascade={"all"})
     * @var [PlaylistVideo]
     */
    protected $playlistVideos;

    function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPosterUrl()
    {
        return $this->poster_url;
    }

    /**
     * @param string $poster_url
     */
    public function setPosterUrl($poster_url)
    {
        $this->poster_url = $poster_url;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
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
     * @return
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param  $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tag->addVideo($this);
        $this->tags[] = $tag;
    }


    public function removeTag(Tag $tag)
    {
        $tag->removeVideo($this);
        $this->tags->removeElement($tag);
    }

    /**
     * @return \Mparaiso\Video\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \Mparaiso\Video\Entity\Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
        //$this->client->addVideo($this);
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

    /**
     * @PrePersist
     */
    public function prePersist()
    {
        if ($this->getCreated() == null) {
            $this->setCreated(new \DateTime);
        }
        if ($this->favorite == null) {
            $this->favorite = false;
        }
        $this->setUpdated(new \DateTime);
    }

    /**
     * @return
     */
    public function getPlaylistVideos()
    {
        return $this->playlistVideos;
    }

    /**
     * @param  $playlistVideos
     */
    public function setPlaylistVideos($playlistVideos)
    {
        $this->playlistVideos = $playlistVideos;
    }

    /**
     * @param $playlistVideo
     * @return Playlist
     */
    public function addPlaylistVideo(PlaylistVideo $playlistVideo)
    {
        $playlistVideo->setVideo($this);
        $this->playlistVideos[] = $playlistVideo;

        return $this;
    }

    /**
     * @param $playlistVideo
     * @return Playlist
     */
    public function removePlaylistVideo($playlistVideo)
    {
        $playlistVideo->setVideo(null);
        $this->playlistVideos->removeElement($playlistVideo);
        return $this;
    }

    /**
     * @return boolean
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * @param boolean $favorite
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;
    }


}