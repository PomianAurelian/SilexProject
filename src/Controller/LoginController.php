<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Handle login GET action and request.
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
        $user = $this->getUser($app);

        return new Response($app['twig']->render('form/login_form.html.twig', [
            'form' => $form->createView(),
            'message' => $message
        ]));
    }

    /**
     * Handle login POST action and request.
     * Route: /post-login
     *
     * @param  Application  $app
     * @param  Request      $request
     * @return JsonResponse
     */
    public function processLoginAction(Application $app, Request $request)
    {
        $data = (array) json_decode($request->getContent());
        $userRepository = new UserRepository($app);
        $user = $userRepository->findOneBy(['username' => $data['username']]);
        if (!$user instanceof User) {
            return new JsonResponse([
                'success' => false,
                'errors' => ['invalid' => 'Username or password (or both) invalid.'],
                'form' => 'login'
            ]);
        } else {
            if ($data['password'] !== $user->password) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => ['invalid' => 'Username or password (or both) invalid.'],
                    'form' => 'login'
                ]);
            } else {
                $app['session']->set('user', [
                        'username' => $user->username,
                        'privilege' => $user->privilege,
                        'id' => $user->id
                ]);
                $app['session']->start();
                return new JsonResponse([
                    'success' => true
                ]);
            }
        }
    }
}
