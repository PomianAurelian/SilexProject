<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper\LoginFormHelper;

/**
 * Login controller
 *
 * @author  Pomian Ghe. Aurelian
 */
class LoginController
{
    /**
     * Handle login action and request.
     * Route: /login
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function loginAction(Application $app, Request $request)
    {
        $loginFormHelper = new LoginFormHelper($app);
        $form = $loginFormHelper->getLoginForm($app);

        return new Response($app['twig']->render('form/login_form.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
