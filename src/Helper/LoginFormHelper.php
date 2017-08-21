<?php

namespace Helper;

use Helper\BaseHelper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Log in form helper.
 *
 * @see BaseHelper
 *
 * @author  Pomian Ghe. Aurelian
 */
class LoginFormHelper extends BaseHelper
{
    public function getLoginForm($app)
    {
        $form = $app['form.factory']->createBuilder(FormType::class)
        ->add('username', TextType::class, array(
                    'label'       => ' ',
                    'attr'        => array('class' => 'input-field'),
                    'constraints' => array(new Assert\NotBlank())
        ))
        ->add('password', PasswordType::class, array(
                    'label'       => ' ',
                    'attr'        => array('class' => 'input-field'),
                    'constraints' => array(new Assert\NotBlank())
        ))
        ->add('privilege', ChoiceType::class, array(
                    'label'   => ' ',
                    'choices' => array(
                        'User'  => 1,
                        'Admin' => 2
                    ),
                    'attr' => array('class' => 'select-field')
        ))
        ->getForm();

        return $form;
    }
}

