<?php

namespace Controller;

use Silex\Application;
use Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
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

class ReviewController
{
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

			$form->handleRequest($request);
			if($form->isValid())
			{
				$app['dbs']['mysql_read']->insert('review', $newReview->setToArray());
				return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
			}
		}
		return new Response($app['twig']->render('form/review_form.html.twig' ,[
			'form' => $form->createView(),
			'company' => $company
		]));
	}

	protected function getReviewForm($app)
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
	                'class'  => 'textarea-field'),
	            'constraints' => new Assert\Length(['max' => 150])
            ))
            ->getForm();

    	return $form;
	}
}