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
 * @author Pomian Ghe. Aurelian
 */
class ReviewFormHelper extends BaseHelper
{
    /**
     * Create and get review form.
     *
     * @return Symfony\Component\Form\Form
     */
    public function getReviewForm()
    {
        $form = $this->app['form.factory']->createBuilder(FormType::class)
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
                'label' => ' '
            ))
            ->add('comment', TextareaType::class, array(
                'label'  => ' ',
                'attr'   =>  array(
                    'class'  => 'textarea-field'
                )
            ))
            ->getForm();

        return $form;
    }
}
