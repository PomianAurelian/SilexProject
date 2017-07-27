<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
	public function indexAction(Application $app, Request $request) 
	{
		return new Response($app['twig']->render('home/index.html.twig'));
	}
}