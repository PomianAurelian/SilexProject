<?php

namespace Controller;

use Silex\Application;
use Silex\Controller;
use Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Controller\CompanyController;
use Repository\CompanyRepository;
use Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompanyFormController extends Controller
{
	public function registerAction(Application $app, Request $request)
	{
		$form = $this->getCompanyForm($app, $request);

		if ($request->isMethod('POST')) {
			$newCompany = new Company();
			$newCompany->setFromArray($request->request->get($form->getName()));

			$em = $this->getDoctrine()->getManager();
	        $em->persist($newCompany);
	        $em->flush();

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

	}
}