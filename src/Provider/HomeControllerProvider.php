<?php

namespace Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * Home Controller Provider
 *
 * @author  Pomian Ghe. Aurelian
 */
class HomeControllerProvider implements ControllerProviderInterface
{
    /**
     * Connect route.
     *
     * @param  Application  $app
     * @return Application/controllers_factory
     */
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers
		->get('/', 'SilexProject\src\controllers\HomeController::indexAction')
		->bind('home');

		return $controllers;
	}
}
