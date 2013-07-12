<?php

namespace Video\Controllers;

use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;
use Video\Entities\User;
use Video\Forms\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
class TestController
{

    function validation($email,Application $app)
    {
        $errors = $app["validator"]->validateValue($email,
            new Assert\MinLength(10)
            );
        if(count($errors)>0){
            $result = (string)$errors;
        }else{
            $result = "The email is valid";
        }

        return $result;
    }

    function userValidation(Request $req,Application $app){
        $user = new User();
        $testClass = new TestClass;
        /* @var Form $form */
        $form = $app["form.factory"]->create(new UserType(),$user);
        if("POST"===$req->getMethod()){
            $form->bindRequest($req);       
            /* @var Session $sess */
            $sess = $app["session"];
            if($form->isValid()){
             
                $sess->getFlashBag()->add("notice","Form is valid!");
                return $app->redirect($app["url_generator"]->generate("test_user_validation"));
            }else{
                $sess->getFlashBag()->add("error","Form has errors!");
            }
        }
        return $app["twig"]->render("test_user_validation.html.twig",array(
            "form"=>$form->createView(),
            )
        );
    }
}