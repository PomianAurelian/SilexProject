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
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class CompanyController
{
	public function indexAction(Application $app, Request $request)
	{
		$companyRepository = new CompanyRepository($app);
		$company = $companyRepository->findCompanyById($id);

			if ($form->isSubmitted() && $form->isValid()) {
	            // perform some action...

	            return $this->redirectToRoute('task_success');
	        }
	    }

		return new Response($app['twig']->render('form/company_form.html.twig' ,[
			'form' => $form->createView()
		]));
	}

	public function saveAction(Application $app, Request $request, $id = NULL)
	{
		if($id === NULL) {
			$form = $this->getCompanyForm($app);
		}
		else {
			$companyRepository = new CompanyRepository($app);
			$company = $companyRepository->findCompanyById($id);
			$form = $this->getEditCompanyForm($app, $company);
		}
		if ($request->isMethod('POST')) {
			$newCompany = new Company();
			$newCompany->setFromArray($request->request->get($form->getName()));
			if ($newCompany->delivery === NULL)
				$newCompany->delivery = 0;
			$form->handleRequest($request);
			// var_dump($form->getErrors());
			// var_dump($form->isValid());die;

			if ($form->isValid())
			{
				if($id === NULL) {
					$app['dbs']['mysql_write']->insert('company', $newCompany->setToArray());
					$id = $app['dbs']['mysql_write']->lastInsertId();
					return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
				} else {
					$newCompany->id = $id;
					$newCompany->logo_src = $company->logo_src;
					$app['dbs']['mysql_write']->update('company', $newCompany->setToArray(), ['id' => $id]);
					return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
				}
			} 
	    }

	    if($id === NULL) {
			return new Response($app['twig']->render('form/company_form.html.twig' ,[
				'message' => '',
				'form' => $form->createView(),
				'action' => 'Register company here'
			]));
		} else {
			return new Response($app['twig']->render('form/company_form.html.twig' ,[
				'message' => '',
				'form' => $form->createView(),
				'company' => $company,
				'action' => 'Edit company '.$company->name
			]));
		}
	}

	public function reviewAction(Application $app, Request $request, $id)
	{
		$form = $this->getReviewForm($app);

		$companyRepository = new CompanyRepository($app);
		$company = $companyRepository->findCompanyById($id);

		if ($request->isMethod('POST')) {
			$newReview = new Review();
			$newReview->setFromArray($request->request->get($form->getName()));

			$newReview->review_date = date('Y-m-d H:i:s');
			$newReview->company_id = $id;

			$app['dbs']['mysql_read']->insert('review', $newReview->setToArray());

			$form->handleRequest($request);

			return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
		}
		$form->handleRequest($request);
		return new Response($app['twig']->render('form/review_form.html.twig' ,[
			'form' => $form->createView(),
			'company' => $company
		]));
	}

	protected function getEditCompanyForm($app, $company)
	{
        $form = $app['form.factory']->createBuilder(FormType::class)
           	->add('name', TextType::class, array(
           		'data'  => $company->name,
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'input-field'),
	            'constraints' => array(new Assert\NotBlank()),
            ))
            ->add('email', EmailType::class, array(
            	'data'  => $company->email,
	            'label'  => ' ',
	            'attr'   =>  array('class'   => 'input-field'),
	            'constraints' => array(new Assert\Email(array(
		            'message' => 'The email "{{ value }}" is not a valid email.',
		            'checkMX' => true,
		        )), new Assert\NotBlank())
            ))	
            ->add('category_id', ChoiceType::class, array(
            	'data'  => $company->category_id,
            	'choices' => array('Restaurant' => 1, 'Fast Food' => 2, 'Market' => 3, 'Drug Store' => 4, 'Other' => 5),
            	'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'select-field')
            ))
            ->add('delivery', CheckboxType::class, array(
            	'data'  => (Boolean)$company->delivery,
	            'label'  => ' ',
	            'required' => false,
	            'attr'   =>  array(
	                'class'   => 'checkbox-field')
            ))
            ->add('radio_choice', ChoiceType::class, array (
            	'data'  => $company->radio_choice,
            	'choices' => array ('Choice A' => 1,
					            	'Choice B' => 2,
					            	'Choice C' => 3),
            	'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'radio-field')
            ))
            ->add('description', TextareaType::class, array(
            	'data'  => $company->description,
	            'label'  => ' ',
	            'required' => false,
	            'attr'   =>  array(
	                'class'  => 'textarea-field'),
	            'constraints' => new Assert\Length(array('max' => 255))
            ))
            ->getForm();
    	return $form;
	}

	protected function getCompanyForm($app)
	{
		$form = $app['form.factory']->createBuilder(FormType::class)
           	->add('name', TextType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'   => 'input-field'),
	            'constraints' => array(new Assert\NotBlank()),
            ))
            ->add('email', EmailType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array('class'   => 'input-field'),
	            'constraints' => array(new Assert\Email(array(
		            'message' => 'The email "{{ value }}" is not a valid email.',
		            'checkMX' => true,
		        )), new Assert\NotBlank())
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
	                'class'  => 'textarea-field'),
	            'constraints' => new Assert\Length(array('max' => 255))
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
	            'constraints' => new Assert\NotBlank();
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
            	'constraints' => new Assert\Length(array('min' => 0.5, 'max' => 5))
            ))
            ->add('comment', TextareaType::class, array(
	            'label'  => ' ',
	            'attr'   =>  array(
	                'class'  => 'textarea-field'),
	            'constraints' => new Assert\Length(['max' => 150])
            ))
            ->getForm();

    	return $form;
	}
}
