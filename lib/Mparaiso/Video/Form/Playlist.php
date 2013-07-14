<?php

namespace Mparaiso\Video\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;

class Playlist extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("title");
        $builder->add("playlistVideos", "collection", array(
            "type" => new PlaylistVideo,
            "allow_add" => true,
            "allow_delete" => true,
            'by_reference' => false,
            "options" => array(
                "with_playlist" => false,
                "with_views" => false,
                "with_ordering"=>false
            )
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "playlist";
    }
}

