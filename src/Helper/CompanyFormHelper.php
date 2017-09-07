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
 * @author Pomian Ghe. Aurelian
 */
class CompanyFormHelper extends BaseHelper
{
    /**
     * Create and get company form.
     *
     * @param  Company                     $company
     * @return Symfony\Component\Form\Form
     */
    public function getCompanyForm(Company $company = null)
    {
        $form = $this->app['form.factory']->createBuilder(FormType::class)
            ->add('name', TextType::class, [
                    'data' => $company instanceof Company ? $company->name : '',
                    'label' => ' ',
                    'attr' => ['class' => 'input-field']
            ])
            ->add('email', EmailType::class, [
                    'data' => $company instanceof Company ? $company->email : '',
                    'label' => ' ',
                    'attr' => ['class' => 'input-field']
            ])
            ->add('category_id', ChoiceType::class, [
                    'data' => $company instanceof Company ? $company->category_id : 1,
                    'choices' => [
                        'Restaurant' => 1,
                        'Fast Food' => 2,
                        'Market' => 3,
                        'Drug Store' => 4,
                        'Other' => 5
                    ],
                    'label' => ' ',
                    'attr' => ['class' => 'select-field']
            ])
            ->add('delivery', CheckboxType::class, [
                    'data' => (Boolean)($company instanceof Company ? $company->delivery : 0),
                    'label' => ' ',
                    'required' => false,
                    'attr' => ['class' => 'checkbox-field']
            ])
            ->add('radio_choice', ChoiceType::class, [
                    'data' => $company instanceof Company ? $company->radio_choice : 1,
                    'choices' => [
                        'Choice A' => 'A',
                        'Choice B' => 'B',
                        'Choice C' => 'C'
                    ],
                    'label' => ' ',
                    'attr' => ['class' => 'radio-field']
            ])
            ->add('description', TextareaType::class, [
                    'data' => $company instanceof Company ? $company->description : '',
                    'label' => ' ',
                    'required' => false,
                    'attr' => array('class' => 'textarea-field')
            ])
            ->add('logo_src', FileType::class, [
                    'empty_data' => $company instanceof Company ? $company->logo_src : 'empty',
                    'label' => ' ',
                    'required' => false,
            ])
            ->getForm();

        return $form;
    }
}
