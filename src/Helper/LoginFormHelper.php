<?php

namespace Helper;

use Helper\BaseHelper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Login form helper.
 *
 * @see BaseHelper
 *
 * @author Pomian Ghe. Aurelian
 */
class LoginFormHelper extends BaseHelper
{
    /**
     * Create and get login form.
     *
     * @return Symfony\Component\Form\Form
     */
    public function getLoginForm()
    {
        $form = $this->app['form.factory']->createBuilder(FormType::class)
            ->add('username', TextType::class, array(
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

