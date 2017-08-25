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
 * @author  Pomian Ghe. Aurelian
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
        echo $_SERVER['REQUEST_URI']; die;

        $userRepository = new UserRepository($app);
        $loginFormHelper = new LoginFormHelper($app);
        $form = $loginFormHelper->getLoginForm($app);
        $message = '';

        if ($request->isMethod('POST')) {
            $loginUser = new User();
            $loginUser->setFromArray($request->request->get($form->getName()));
            $user = $userRepository->findUser($loginUser->username);

            if (null === $user) {
                $message = 'User does not exist!';
            } else {

                if ($user->password != $loginUser->password) {
                    $message = 'Invalid password!';
                } else {
                    $form->handleRequest($request);

                    if ($form->isValid()) {
                        $app['session']->set('user', [
                                'username' => $user->username,
                                'privilege' => $user->privilege,
                                'id' => $user->id
                        ]);
                        $app['session']->start();

                        return $app->redirect($app["url_generator"]->generate("homepage"));
                    }
                }
            }
        }

        $user = $this->getUser($app);

        return new Response($app['twig']->render('form/login_form.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
            'user' => $user
        ]));
    }
}
