<?php

namespace Controller;

use Silex\Application;
use Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController
{
	public function indexAction(Application $app, Request $request)
	{
		$companyRepository = new CompanyRepository($app);
		$companiesGroupedByCategory = $companyRepository->findAllAsArraysGroupedByCategory();

		$categoryRepository = new CategoryRepository($app);
		$categories = $categoryRepository->findAll();
		$form = $this->getForm($app, $request);

		return new Response($app['twig']->render('home/index.html.twig', [
			'companiesGroupedByCategory' => $companiesGroupedByCategory,
			'categories' => $categories,
			'form' => $form->createView()
		]));
	}

	private function getForm($app, $request)
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
            ->add('category', ChoiceType::class, array(
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
            ->add('radio', ChoiceType::class, array (
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

    	$form->handleRequest($request);

    	return $form;
	}
}
