<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomepageController
{
	public function indexAction(Application $app, Request $request) 
	{
		$companyNames = [
			'Google',
			'AlgoTech',
			'Yahoo'
		];

		return new Response($app['twig']->render('homepage/index.html.twig', ['company_names' => $companyNames]));
	}
}