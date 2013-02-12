<?php

namespace Video\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlaylistVideoRelation
 */
class PlaylistVideoRelation
{
    /**
     * @var integer
     */
    private $order;

    /**
     * @var \DateTime
     */
    private $added_at;

    /**
     * @var \Video\Entities\Video
     */
    private $video;


    /**
     * Set order
     *
     * @param integer $order
     * @return PlaylistVideoRelation
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set added_at
     *
     * @param \DateTime $addedAt
     * @return PlaylistVideoRelation
     */
    public function setAddedAt($addedAt)
    {
        $this->added_at = $addedAt;
    
        return $this;
    }

    /**
     * Get added_at
     *
     * @return \DateTime 
     */
    public function getAddedAt()
    {
        return $this->added_at;
    }

    /**
     * Set video
     *
     * @param \Video\Entities\Video $video
     * @return PlaylistVideoRelation
     */
    public function setVideo(\Video\Entities\Video $video = null)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return \Video\Entities\Video 
     */
    public function getVideo()
    {
        return $this->video;
    }
    /**
     * @var \Video\Entities\Playlist
     */
    private $playlist;


    /**
     * Set playlist
     *
     * @param \Video\Entities\Playlist $playlist
     * @return PlaylistVideoRelation
     */
    public function setPlaylist(\Video\Entities\Playlist $playlist = null)
    {
        $this->playlist = $playlist;
    
        return $this;
    }

    /**
     * Get playlist
     *
     * @return \Video\Entities\Playlist 
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }
}