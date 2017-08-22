<?php

namespace Helper;

use Helper\BaseHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review form helper
 *
 * @see BaseHelper
 *
 * @author  Pomian Ghe. Aurelian
 */
class ReviewFormHelper extends BaseHelper
{
    /**
     * Create and get review form.
     *
     * @param  Application                 $app
     * @return Symfony\Component\Form\Form
     */
    public function getReviewForm($app)
    {
        $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('name', TextType::class, array(
                'label'  => ' ',
                'attr'   =>  array(
                    'class'   => 'input-field'),
                'constraints' => new Assert\NotBlank()
            ))
            ->add('rating', ChoiceType::class, array (
                'choices' => array (
                    '0.5' => 0.5,
                    '1.0' => 1,
                    '1.5' => 1.5,
                    '2.0' => 2,
                    '2.5' => 2.5,
                    '3.0' => 3,
                    '3.5' => 3.5,
                    '4.0' => 4,
                    '4.5' => 4.5,
                    '5.0' => 5
                ),
                'label' => ' ',
                'constraints' => new Assert\Length(array('min' => 0.5, 'max' => 5.0))
            ))
            ->add('comment', TextareaType::class, array(
                'label'  => ' ',
                'attr'   =>  array(
                    'class'  => 'textarea-field'
                ),
                'constraints' => new Assert\Length(['max' => 150])
            ))
            ->getForm();

        return $form;
    }
}
