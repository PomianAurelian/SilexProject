<?php

namespace Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * Company Controller Provider
 *
 * @author  Pomian Ghe. Aurelian
 */
class CompanyControllerProvider implements ControllerProviderInterface
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
		->get('/', 'SilexProject\src\controllers\CompanyController::indexAction')
		->bind('company');

		return $controllers;
	}
}
