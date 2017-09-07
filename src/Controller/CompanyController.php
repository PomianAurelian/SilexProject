<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Repository\CompanyRepository;
use Repository\ReviewRepository;
use Entity\Company;
use Entity\User;
use Helper\CompanyFormHelper;
use Controller\BaseController;
use Service\CompanyService;
use Helper\ValidatorHelper;

/**
 * Company Controller
 *
 * @see BaseController
 *
 * @author Pomian Ghe. Aurelian
 */
class CompanyController extends BaseController
{
    /**
     * Handle company page action and request.
     * Route: /company/{id}
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  int         $id
     * @return Response
     */
    public function indexAction(Application $app, Request $request, int $id)
    {
        $companyRepository = new CompanyRepository($app);
        $company = $companyRepository->findOneBy(['id' => $id]);

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));
        }

        $reviewRepository = new ReviewRepository($app);
        $reviews = $reviewRepository->findBy(['company_id' => $id]);
        $average = $reviewRepository->getCompanyAverageRating($id);
        $user = $this->getUser($app);

        $companyService = new CompanyService($app);

        $reviewed = $companyService->userHasReview($company, $user);

        return new Response($app['twig']->render('company/company.html.twig', [
            'company' => $company,
            'reviews' => $reviews,
            'average' => $average,
            'reviewed' => $reviewed
        ]));
    }

    /**
     * Handle company form page GET action and request for register and edit company.
     * Route: /company-save | /company-save/{$id}
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  int         $id
     * @return Response
     */
    public function createEditCompanyAction(Application $app, Request $request, int $id = null)
    {
        $companyFormHelper = new CompanyFormHelper($app);

        if (null === $id) {
            $company = new Company();
        } else {
            $companyRepository = new CompanyRepository($app);
            $company = $companyRepository->findOneBy(['id' => $id]);
        }

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));
        }

        $form = $companyFormHelper->getCompanyForm($company);
        $user = $this->getUser($app);

        if (!$user instanceof User) {
            return $app->redirect($app['url_generator']->generate('home'));

        }

        $action = $id ? 'Edit company ' . $company->name : 'Register company here';

        return new Response($app['twig']->render('form/company_form.html.twig', [
            'message' => '',
            'form' => $form->createView(),
            'company' => $company,
            'action' => $action
        ]));
    }

    /**
     * Handle company form page POST action and request for register and edit company.
     * Route: /post-company | post-company/{$id}
     *
     * @param  Application  $app
     * @param  Request      $request
     * @return JsonResponse
     */
    public function processCompanySaveAction(Application $app, Request $request)
    {
        $data = (array) json_decode($request->getContent());

        if (8 === count($data)) {
            $id = $data['id'];
        } else {
            $id = null;
        }

        if (null === $id) {
            $company = new Company();
        } else {
            $companyRepository = new CompanyRepository($app);
            $company = $companyRepository->findOneBy(['id' => $id]);
        }

        $data['logo_src'] = $company->logo_src;
        $company->setFromArray($data);
        $errors = $app['validator']->validate($company);
        $user = $this->getUser($app);
        $validatorHelper = new ValidatorHelper($app);

        if (0 < count($errors)) {
            $errorsArr = $validatorHelper->getErrorsArr($errors);
            return new JsonResponse([
                'success' => false,
                'errors' => $errorsArr,
                'form' => 'company'
            ]);
        } else {
            if (null === $id) {
                $company->user_id = $user->id;
                $app['dbs']['mysql_write']->insert('company', $company->toArray());
                $id = (int) $app['dbs']['mysql_write']->lastInsertId();
            } else {
                $app['dbs']['mysql_write']->update('company', $company->toArray(), ['id' => $id]);
            }

            return new JsonResponse([
                'success' => true,
                'id' => $id
            ]);
        }
    }
}
