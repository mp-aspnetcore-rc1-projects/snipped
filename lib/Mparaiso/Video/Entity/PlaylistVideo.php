<?php

namespace Mparaiso\Video\Entity;

/**
 *
 * @Entity
 * @Table(name="mp_video_playlistvideos")
 *
 */
class PlaylistVideo
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var integer
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="\Mparaiso\Video\Entity\Playlist",inversedBy="playlistVideos",cascade={"persist"})
     * @var Playlist
     */
    protected $playlist;
    /**
     * @ManyToOne(targetEntity="Mparaiso\Video\Entity\Video",inversedBy="playlistVideos",cascade={"persist"})
     * @var Video
     */
    protected $video;
    /**
     * @Column(type="integer",nullable=true)
     * @var integer
     */
    protected $ordering;
    /**
     * @Column(type="integer",nullable=true)
     * @var
     */
    protected $views;

    /**
     * @return \Mparaiso\Video\Entity\Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * @param \Mparaiso\Video\Entity\Playlist $playlist
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * @return \Mparaiso\Video\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param \Mparaiso\Video\Entity\Video $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param int $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }
}
