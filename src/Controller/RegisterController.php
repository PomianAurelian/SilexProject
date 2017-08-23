<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper\RegisterFormHelper;

/**
 * Register controller
 *
 * @author  Pomian Ghe. Aurelian
 */
class RegisterController
{
    /**
     * Handle register action and request.
     * Route: /register
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function registerAction(Application $app, Request $request)
    {
        $loginFormHelper = new RegisterFormHelper($app);
        $form = $loginFormHelper->getRegisterForm($app);
        $password = 'a';

        return new Response($app['twig']->render('form/register_form.html.twig', [
            'form' => $form->createView(),
            'password' => $password
        ]));
    }
}
