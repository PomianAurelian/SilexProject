<?php

namespace Helper;

use Helper\BaseHelper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Register form helper.
 *
 * @see BaseHelper
 *
 * @author Pomian Ghe. Aurelian
 */
class RegisterFormHelper extends BaseHelper
{
    /**
     * Create and get register form.
     *
     * @return Symfony\Component\Form\Form
     */
    public function getRegisterForm()
    {
        $form = $this->app['form.factory']->createBuilder(FormType::class)
            ->add('username', TextType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field'),
                        'constraints' => array(new Assert\NotBlank())
            ))
            ->add('email', EmailType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field'),
                        'constraints' => array(new Assert\Email(array(
                            'message'     => 'The email "{{ value }}" is not a valid email.',
                            'checkMX'     => true,
                        )), new Assert\NotBlank())
                ))
            ->add('password', PasswordType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field'),
                        'constraints' => array(new Assert\NotBlank())
            ))
            ->getForm();

        return $form;
    }
}

