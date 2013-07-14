<?php

namespace Mparaiso\Video\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class Tag extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("title");
        if ($options["show_video"] == true)
            $builder->add("videos");

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Mparaiso\Video\Entity\Tag', "show_video" => true));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "tag";
    }
}