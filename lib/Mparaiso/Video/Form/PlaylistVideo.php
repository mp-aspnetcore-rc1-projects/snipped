<?php
namespace Mparaiso\Video\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class PlaylistVideo extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($options["with_playlist"] == true) {
            $builder->add("playlist");
        }

        $builder->add("video");

        if ($options["with_ordering"] == true) {
            $builder->add("ordering",null,array("required"=>false));
        }
        if ($options["with_views"] == true) {
            $builder->add("views",null,array("required"=>false));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mparaiso\Video\Entity\PlaylistVideo',
            "with_playlist" => true,
            "with_views" => true,
            "with_ordering" => true
        ));
    }

    function getName()
    {
        return "playlist_video";
    }
}