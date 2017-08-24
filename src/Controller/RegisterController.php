<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper\RegisterFormHelper;
use Entity\User;

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
        $registerFormHelper = new RegisterFormHelper($app);
        $form = $registerFormHelper->getRegisterForm($app);

        if ($request->isMethod('POST')) {
            $newUser = new User();
            $newUser->setFromArray($request->request->get($form->getName()));

            $form->handleRequest($request);
            if ($form->isValid()) {
                $app['dbs']['mysql_read']->insert('user', $newUser->toArray());

                return $app->redirect($app["url_generator"]->generate("login"));
            }
        }

        return new Response($app['twig']->render('form/register_form.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
