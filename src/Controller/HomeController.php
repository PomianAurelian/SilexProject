<?php

namespace Controller;

use Silex\Application;
use Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\CategoryRepository;

/**
 * Home Controller
 *
 * @author  Pomian Ghe. Aurelian
 */
class HomeController
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

        return new Response($app['twig']->render('home/index.html.twig', [
            'companiesGroupedByCategory' => $companiesGroupedByCategory,
            'categories' => $categories
        ]));
    }
}
