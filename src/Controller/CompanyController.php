<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\ReviewRepository;
use Entity\Company;
use Entity\Review;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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

	public function saveAction(Application $app, Request $request)
	{
		$form = $this->getCompanyForm($app);

		if ($request->isMethod('POST')) {
			$newCompany = new Company();
			$newCompany->setFromArray($request->request->get($form->getName()));
			if ($newCompany->delivery === NULL)
				$newCompany->delivery = 0;
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

	public function reviewAction(Application $app, Request $request, $id)
	{
		$form = $this->getReviewForm($app);

		if ($request->isMethod('POST')) {
			$newReview = new Review();
			$newReview->setFromArray($request->request->get($form->getName()));

			$newReview->review_date = date('Y-m-d H:i:s');
			$newReview->company_id = $id;

			$app['dbs']['mysql_read']->insert('review', $newReview->setToArray());

			if ($form->isSubmitted() && $form->isValid()) {
	            // perform some action...

	            return $this->redirectToRoute('task_success');
	        }
		}
		$companyRepository = new CompanyRepository($app);
		$company = $companyRepository->findCompanyById($id);

		return new Response($app['twig']->render('form/review_form.html.twig' ,[
			'form' => $form->createView(),
			'company' => $company
		]));
	}

	protected function getCompanyForm($app)
	{
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
            	// 'expanded' => true,
            	'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'radio-field')
            ))
            ->add('description', TextareaType::class, array(
	            'label'  => ' ',
	            'required' => false,
	            'attr'   =>  array(
	                'class'  => 'textarea-field')
            ))
            ->getForm();

    	return $form;
	}

	protected function getReviewForm($app)
	{
        $form = $app['form.factory']->createBuilder(FormType::class)
           	->add('name', TextType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'input-field')
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
            	'label' => ' '
            ))
            ->add('comment', TextareaType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'  => 'textarea-field')
            ))
            ->getForm();

    	return $form;
	}
}
