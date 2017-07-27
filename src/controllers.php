<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Provider\HomeControllerProvider;
use Provider\CompanyControllerProvider;
use Controller\HomeController;
use Controller\CompanyController;


use Home\Provider;


$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['home.controller'] = function() use ($app) {
    return new HomeController();
};
$app['company.controller'] = function() use ($app) {
    return new CompanyController();
};
$app->get('/home', "home.controller:indexAction");
$app->get('/company', "company.controller:indexAction");

// $app->mount('/', new HomepageControllerProvider());
//Request::setTrustedProxies(array('127.0.0.1'));

// $app->get('/', function () use ($app) {
//     return $app['twig']->render('index.html.twig', array());
// })
// ->bind('homepage');

// $app->get('/home', function () use ($app) {
//     return $app['twig']->render('home.html', array());
// })
// ->bind('home');

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