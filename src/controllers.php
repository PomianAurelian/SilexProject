<?php

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Controller\HomeController;
use Controller\CompanyFormController;
use Controller\CompanyController;
use Controller\ReviewController;
use Controller\LoginController;
use Controller\TestController;
use Controller\RegisterController;
use AppBundle\DependencyInjection\Configuration;
use Home\Provider;
use Entity\User;
use Service\UserService;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'mysql_read' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'silex_project',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4'
        ),
        'mysql_write' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'silex_project',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4'
        )
    )
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
    'translator.domains' => array(),
));
$app->register(new FormServiceProvider());

$app->extend('twig', function($twig, $app) {
    $userService = new UserService($app);
    $twig->addGlobal('user', $userService->getAuthenticatedUser());
    $twig->addGlobal('privilegeDefault', User::PRIVILEGE_DEFAULT);
    $twig->addGlobal('privilegeAdmin', User::PRIVILEGE_ADMIN);
    $twig->addGlobal('privilegeSuperAdmin', User::PRIVILEGE_SUPER_ADMIN);

    return $twig;
});
$app['home.controller'] = function() use ($app) {
    return new HomeController();
};
$app['company.controller'] = function() use ($app) {
    return new CompanyController();
};
$app['review.controller'] = function() use ($app) {
    return new ReviewController();
};
$app['login.controller'] = function() use ($app) {
    return new LoginController();
};
$app['register.controller'] = function() use ($app) {
    return new RegisterController();
};
$app['test.controller'] = function() use ($app) {
    return new TestController();
};

$app->get('/home', "home.controller:indexAction")->bind('home');
$app->get('/company/{id}', "company.controller:indexAction")->bind('company_details');
$app->get('/company-save', "company.controller:createEditCompany")->bind('company_save');
$app->post('/post-company', "company.controller:postAction");
$app->get('/review/{id}', "review.controller:createReviewAction");
$app->post('/post-review', "review.controller:postAction");
$app->get('/company-save/{id}', "company.controller:createEditCompany");
$app->post('/post-company/{id}', "company.controller:postAction");
$app->get('/login', "login.controller:loginAction")->bind('login');
$app->post('/post-login', "login.controller:postAction");
$app->get('/register', "register.controller:registerAction");
$app->post('/post-register', "register.controller:postAction");
$app->get('/logout', "home.controller:logoutAction");
$app->get('/test', "test.controller:loginAction");
$app->post('/post-test', "test.controller:testPostAction");

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
