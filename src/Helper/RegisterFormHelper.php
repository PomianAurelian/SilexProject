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
        $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('username', TextType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field')
            ))
            ->add('email', EmailType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field')
            ))
            ->add('password', PasswordType::class, array(
                        'label'       => ' ',
                        'attr'        => array('class' => 'input-field')
            ))
            ->getForm();

        return $form;
    }
}

