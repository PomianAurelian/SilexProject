<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Helper\RegisterFormHelper;
use Entity\User;
use Helper\ValidatorHelper;
use Controller\BaseController;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Register controller
 *
 * @see BaseController
 *
 * @author Pomian Ghe. Aurelian
 */
class RegisterController extends BaseController
{
    /**
     * Handle register GET action and request.
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
        $user = $this->getUser($app);

        if (!$user instanceof User) {
            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        return new Response($app['twig']->render('form/register_form.html.twig', [
            'form' => $form->createView()
        ]));
    }

    /**
     * Handle register POST action and request.
     * Route: /post-register
     *
     * @param  Application $app
     * @param  Request     $request
     * @return JsonResponse
     */
    public function processRegisterAction(Application $app, Request $request)
    {
        $data = (array) json_decode($request->getContent());
        $newUser = new User();
        $newUser->setFromArray($data);
        $errors = $app['validator']->validate($newUser);
        $validatorHelper = new ValidatorHelper($app);

        if (0 < count($errors)) {
            $errorsArr = $validatorHelper->getErrorsArr($errors);
            return new JsonResponse([
                'success' => false,
                'errors' => $errorsArr,
                'form' => 'register'
            ]);
        } else {
            $app['dbs']['mysql_read']->insert('user', $newUser->toArray());

            return new JsonResponse([
                'success' => true
            ]);
        }
    }
}
