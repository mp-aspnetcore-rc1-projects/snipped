<?php

namespace Mparaiso\Video\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class Video extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("title");
        $builder->add("link");
        $builder->add("poster_url");
        $builder->add("description", "textarea");
        $builder->add("favorite",null,array("label"=>"Promote to homepage"));
        $builder->add("client");
        $builder->add("tags", 'collection',
            array('type' => new Tag(),
                "allow_add" => true,
                "allow_delete"=>true,
                'by_reference' => false,
                "options" => array("show_video" => false),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mparaiso\Video\Entity\Video',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "video";
    }
}

