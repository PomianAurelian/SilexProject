<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController
{
	public function indexAction(Application $app, Request $request) 
	{
		return new Response($app['twig']->render('company/company.html.twig'));
	}
}