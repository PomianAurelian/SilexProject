<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Provider\HomeControllerProvider;
use Provider\CompanyControllerProvider;
use Provider\DatabaseControllerProvider;
use Controller\HomeController;
use Controller\CompanyFormController;
use Controller\CompanyController;
use Controller\DatabaseController;
use AppBundle\DependencyInjection\Configuration;
use Home\Provider;


$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array (
        'mysql_read' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'silex_project',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4',
        ),
        'mysql_write' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'silex_project',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4',
        ),
    ),
));

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
    'translator.domains' => array(),
));
$app->register(new FormServiceProvider());

$app['home.controller'] = function() use ($app) {
    return new HomeController();
};
$app['company.controller'] = function() use ($app) {
    return new CompanyController();
};

$app->get('/home', "home.controller:indexAction");
$app->get('/company', "company.controller:indexAction");
$app->get('/company/{id}', "company.controller:indexAction");
$app->get('/company-save', "company.controller:saveAction");
$app->post('/company-save', "company.controller:saveAction");
$app->get('/review/{id}', "company.controller:reviewAction");
$app->post('/review/{id}', "company.controller:reviewAction");
$app->get('/company-edit/{id}', "company.controller:editAction");
$app->post('/company-edit/{id}', "company.controller:editAction");

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
