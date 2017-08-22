<?php

namespace Helper;

use Entity\Company;
use Helper\BaseHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company form helper
 *
 * @see BaseHelper
 *
 * @author  Pomian Ghe. Aurelian
 */
class CompanyFormHelper extends BaseHelper
{
    /**
     * Create and get company form.
     *
     * @param  Application                 $app
     * @param  Company                     $company
     * @return Symfony\Component\Form\Form
     */
    public function getCompanyForm(Company $company = null)
    {
        $form = $this->app['form.factory']->createBuilder(FormType::class)
            ->add('name', TextType::class, array(
                    'data'        => $company instanceof Company ? $company->name : '',
                    'label'       => ' ',
                    'attr'        => array('class' => 'input-field'),
                    'constraints' => array(new Assert\NotBlank())
            ))
            ->add('email', EmailType::class, array(
                    'data'        => $company instanceof Company ? $company->email : '',
                    'label'       => ' ',
                    'attr'        => array('class' => 'input-field'),
                    'constraints' => array(new Assert\Email(array(
                        'message'     => 'The email "{{ value }}" is not a valid email.',
                        'checkMX'     => true,
                    )), new Assert\NotBlank())
            ))
            ->add('category_id', ChoiceType::class, array(
                    'data'    => $company instanceof Company ? $company->category_id : 1,
                    'choices' => array(
                        'Restaurant' => 1,
                        'Fast Food'  => 2,
                        'Market'     => 3,
                        'Drug Store' => 4,
                        'Other'      => 5
                    ),
                    'label' => ' ',
                    'attr'  => array('class' => 'select-field')
            ))
            ->add('delivery', CheckboxType::class, array(
                    'data'     => (Boolean)($company instanceof Company ? $company->delivery : 0),
                    'label'    => ' ',
                    'required' => false,
                    'attr'     => array('class' => 'checkbox-field')
            ))
            ->add('radio_choice', ChoiceType::class, array (
                    'data'    => $company instanceof Company ? $company->radio_choice : 1,
                    'choices' => array (
                        'Choice A' => 1,
                        'Choice B' => 2,
                        'Choice C' => 3
                    ),
                    'label' => ' ',
                    'attr'  => array('class' => 'radio-field')
            ))
            ->add('description', TextareaType::class, array(
                    'data'        => $company instanceof Company ? $company->description : '',
                    'label'       => ' ',
                    'required'    => false,
                    'attr'        => array('class' => 'textarea-field'),
                    'constraints' => new Assert\Length(array('max' => 255))
            ))
            ->add('FileUpload', FileType::class, array (
                    'label'    => ' ',
                    'required' => false,
            ))
            ->getForm();

        return $form;
    }
}
