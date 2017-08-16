<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyController
{
	public function indexAction(Application $app, Request $request, $id)
	{
		$companyRepository = new CompanyRepository($app);
		$company = $companyRepository->findCompanyById($id);

        $reviewRepository = new ReviewRepository($app);
        $reviews = $reviewRepository->findAllForThisCompanyId($id);

        $average = $reviewRepository->getAverageRatingForThisCompanyId($id);

		return new Response($app['twig']->render('company/company.html.twig' ,[
            'company' => $company,
            'reviews' => $reviews,
            'average' => $average
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

			if ($form->isValid())
			{
				$files = $request->files->get($form->getName());
	            $path = 'images/company/';
	            if( $files['FileUpload'] != null ){
	            	$filename = $files['FileUpload']->getClientOriginalName();
	            	$files['FileUpload']->move($path,$filename);
					$newCompany->logo_src = $filename;
	            } else {
	            	$newCompany->logo_src = $company->logo_src;
	            }

				if($id === NULL) {
					$app['dbs']['mysql_write']->insert('company', $newCompany->toArray());
					$id = $app['dbs']['mysql_write']->lastInsertId();
					return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
				} else {
					$newCompany->id = $id;
					$app['dbs']['mysql_write']->update('company', $newCompany->toArray(), ['id' => $id]);
					return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
				}
			}
	    }

	    if($id === NULL) {
			return new Response($app['twig']->render('form/company_form.html.twig' ,[
				'message' => '',
				'form' => $form->createView(),
				'company' => null,
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
            ->add('FileUpload', FileType::class, array (
            	'label' => ' ',
            	'required' => false,
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
            ->add('FileUpload', FileType::class, array (
            	'label' => ' '
            ))
            ->getForm();
    	return $form;
	}
}
