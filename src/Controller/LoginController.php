<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper\LoginFormHelper;
use Entity\User;
use Repository\UserRepository;
use Controller\BaseController;

/**
 * Login controller
 *
 * @see BaseController
 *
 * @author Pomian Ghe. Aurelian
 */
class LoginController extends BaseController
{
    /**
     * Handle login action and request.
     * Route: /login
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  string      $message
     * @return Response
     */
    public function loginAction(Application $app, Request $request)
    {
        $userRepository = new UserRepository($app);
        $loginFormHelper = new LoginFormHelper($app);
        $form = $loginFormHelper->getLoginForm($app);
        $message = '';

        if ($request->isMethod('POST')) {
            $loginUser = $request->request->get($form->getName());
            $user = $userRepository->findOneBy(['username' => $loginUser['username']]);

            if (null === $user || $user->password != $loginUser['password']) {
                $message = 'Invalid credentials!';
            } else {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $app['session']->set('user', [
                            'username' => $user->username,
                            'privilege' => $user->privilege,
                            'id' => $user->id
                    ]);
                    $app['session']->start();

                    return $app->redirect($app["url_generator"]->generate("home"));
                }
            }
        }

        $user = $this->getUser($app);

        return new Response($app['twig']->render('form/login_form.html.twig', [
            'form' => $form->createView(),
            'message' => $message
        ]));
    }
}
