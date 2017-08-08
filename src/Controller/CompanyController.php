<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\ReviewRepository;

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
}