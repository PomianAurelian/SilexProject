<?php

namespace Controller;

use Silex\Application;
use Entity\Review;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class ReviewController
{
    /**
     * Handle review form page action and request.
     * Route: /review/{id}
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  int         $id
     * @return Response
     */
	public function reviewAction(Application $app, Request $request, $id)
	{
		$form = $this->getReviewForm($app);

		$companyRepository = new CompanyRepository($app);
		$company = $companyRepository->find($id);

		if ($request->isMethod('POST')) {
			$newReview = new Review();
			$newReview->setFromArray($request->request->get($form->getName()));

			$newReview->review_date = date('Y-m-d H:i:s');
			$newReview->company_id = $id;

			$form->handleRequest($request);
			if($form->isValid())
			{
				$app['dbs']['mysql_read']->insert('review', $newReview->toArray());
				return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
			}
		}
		return new Response($app['twig']->render('form/review_form.html.twig' ,[
			'form' => $form->createView(),
			'company' => $company
		]));
	}

    /**
     * Create and get review form.
     *
     * @param  Application                 $app
     * @return Symfony\Component\Form\Form
     */
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
