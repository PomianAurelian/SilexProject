<?php 

namespace Form;

use Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class CompanyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('category', ChoiceType::class, array(
            	'choices' => array('Restaurant' => 1, 'Fast Food' => 2, 'Market' => 3, 'Drug Store' => 4, 'Other' => 5),
            	'expanded' => true,
            ))
            ->add('delivery', CheckboxType::class)
            ->add('radio', RadioType::class)
            ->add('description', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Company::class,
        ));
    }
}