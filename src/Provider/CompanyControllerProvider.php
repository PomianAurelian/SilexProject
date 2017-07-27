<?php

namespace Provider;

use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\ControllerProviderInterface;

class CompanyControllerProvider implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		$controllers
		->get('/', 'SilexProject\src\controllers\CompanyController::indexAction')
		->bind('company');

		return $controllers;
	}
}