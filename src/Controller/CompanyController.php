<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\ReviewRepository;
use Entity\Company;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompanyController
{
	public function indexAction(Application $app, Request $request)
	{
		return new Response($app['twig']->render('company/company.html.twig'));
	}

	public function saveAction(Application $app, Request $request)
	{
		$form = $this->getCompanyForm($app);

		if ($request->isMethod('POST')) {
			$newCompany = new Company();
			$newCompany->setFromArray($request->request->get($form->getName()));
			$app['dbs']['mysql_read']->insert('company', $newCompany->setToArray());

			if ($form->isSubmitted() && $form->isValid()) {
	            // perform some action...

	            return $this->redirectToRoute('task_success');
	        }
	    }

		return new Response($app['twig']->render('form/company_form.html.twig' ,[
			'form' => $form->createView()
		]));
	}

	protected function getCompanyForm($app)
	{
		$company = new Company();

        $form = $app['form.factory']->createBuilder(FormType::class)
           	->add('name', TextType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'input-field')
            ))
            ->add('email', EmailType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'input-field')
            ))
            ->add('category_id', ChoiceType::class, array(
            	'choices' => array('Restaurant' => 1, 'Fast Food' => 2, 'Market' => 3, 'Drug Store' => 4, 'Other' => 5),
            	'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'select-field')
            ))
            ->add('delivery', CheckboxType::class, array(
	            'label'  => ' ',
	            'required' => false,
	            'attr'   =>  array(
	                'class'   => 'checkbox-field')
            ))
            ->add('radio_choice', ChoiceType::class, array (
            	'choices' => array ('Choice A' => 1,
					            	'Choice B' => 2,
					            	'Choice C' => 3),
            	'expanded' => true,
            	'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'radio-field')
            ))
            ->add('description', TextType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'  => 'textarea-field')
            ))
            ->getForm();

    	return $form;
	}
}
