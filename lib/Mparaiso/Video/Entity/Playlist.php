<?php

namespace Mparaiso\Video\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="mp_video_playlists")
 *
 */
class Playlist
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
     * @OneToMany(targetEntity="\Mparaiso\Video\Entity\PlaylistVideo",mappedBy="playlist",cascade={"all"})
     * @var [PlaylistVideo]
     */
    protected $playlistVideos;

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

    function __construct()
    {
        $this->playlistVideos = new ArrayCollection();
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
     * @return \Mparaiso\Video\Entity\PlaylistVideo
     */
    public function getPlaylistVideos()
    {
        return $this->playlistVideos;
    }

    /**
     * @param \Mparaiso\Video\Entity\PlaylistVideo $playlistVideos
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
        $playlistVideo->setPlaylist($this);
        $this->playlistVideos[] = $playlistVideo;
        return $this;
    }

    /**
     * @param $playlistVideo
     * @return Playlist
     */
    public function removePlaylistVideo(PlaylistVideo $playlistVideo)
    {
        $playlistVideo->setPlaylist(null);
        $this->playlistVideos->removeElement($playlistVideo);
        return $this;
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
        $this->setUpdated(new \DateTime);
    }
}


