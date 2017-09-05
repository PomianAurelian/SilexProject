<?php

namespace Controller;

use Silex\Application;
use Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\CategoryRepository;
use Controller\BaseController;
use Entity\User;

/**
 * Home Controller
 *
 * @see BaseController
 *
 * @author Pomian Ghe. Aurelian
 */
class HomeController extends BaseController
{
    /**
     * Handle home page action and request.
     * Route: /home
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function indexAction(Application $app, Request $request)
    {
        $companyRepository = new CompanyRepository($app);
        $companiesGroupedByCategory = $companyRepository->findAllAsArraysGroupedByCategory();

        $categoryRepository = new CategoryRepository($app);
        $categories = $categoryRepository->findAll();

        if (null === $categories) {
            return new Response($app['twig']->render('errors/default.html.twig'));
        }

        $user = $this->getUser($app);

        return new Response($app['twig']->render('home/index.html.twig', [
            'companiesGroupedByCategory' => $companiesGroupedByCategory,
            'categories' => $categories
        ]));
    }

    /**
     * Logout action.
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function logoutAction(Application $app, Request $request)
    {
        $app['session']->start();
        $app['session']->invalidate();

        return $app->redirect($app["url_generator"]->generate("home"));
    }
}
