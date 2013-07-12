<?php

namespace Video\Forms;

use  Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType{

    function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add("username","text")
            ->add("email","email");
    }

    function getName(){
        return "user";
    }
}