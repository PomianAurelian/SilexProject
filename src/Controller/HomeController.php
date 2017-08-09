<?php

namespace Controller;

use Silex\Application;
use Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\CategoryRepository;

class HomeController
{
	public function indexAction(Application $app, Request $request)
	{
		$companyRepository = new CompanyRepository($app);
		$companiesGroupedByCategory = $companyRepository->findAllAsArraysGroupedByCategory();

		$categoryRepository = new CategoryRepository($app);
		$categories = $categoryRepository->findAll();

		return new Response($app['twig']->render('home/index.html.twig', [
			'companiesGroupedByCategory' => $companiesGroupedByCategory,
			'categories' => $categories
		]));
	}
}
