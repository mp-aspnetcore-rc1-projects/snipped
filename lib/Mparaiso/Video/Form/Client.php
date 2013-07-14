<?php


namespace Mparaiso\Video\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class Client extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("name");
        $builder->add("videos", null, array(
            "expanded" => true,
            "multiple" => true,
            'by_reference' => true,
            "class" => '\Mparaiso\Video\Entity\Video'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Mparaiso\Video\Entity\Client'));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "client";
    }
}

