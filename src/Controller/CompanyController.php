<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Repository\ReviewRepository;
use Entity\Company;
use Helper\CompanyFormHelper;
use Controller\BaseController;

/**
 * Company Controller
 *
 * @author  Pomian Ghe. Aurelian
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
        $company = $companyRepository->find($id);

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));
        }

        $reviewRepository = new ReviewRepository($app);
        $reviews = $reviewRepository->findAllForThisCompanyId($id);

        $average = $reviewRepository->getAverageRatingForThisCompanyId($id);
        $user = $this->getUser($app);
        $reviewed = $this->checkForReview($reviews, (int) $user['id']);

        return new Response($app['twig']->render('company/company.html.twig', [
            'company' => $company,
            'reviews' => $reviews,
            'average' => $average,
            'reviewed' => $reviewed,
            'user' => $user
        ]));
    }

    /**
     * Handle company form page action and request for register and edit company.
     * Route: /company-save | /company-save/{$id}
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  int         $id
     * @return Response
     */
    public function createEditCompany(Application $app, Request $request, int $id = null)
    {
        $companyFormHelper = new CompanyFormHelper($app);

        if (null === $id) {
            $company = new Company();
        } else {
            $companyRepository = new CompanyRepository($app);
            $company = $companyRepository->find($id);
        }

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));
        }

        $form = $companyFormHelper->getCompanyForm($company);
        $user = $this->getUser($app);

        if ($request->isMethod('POST')) {
            $company->setFromArray($request->request->get($form->getName()));

            $form->handleRequest($request);

            if ($form->isValid()) {
                $files = $request->files->get($form->getName());
                $path = 'images/company/';

                if ($files['FileUpload'] != null ){
                    $filename = $files['FileUpload']->getClientOriginalName();
                    $files['FileUpload']->move($path, $filename);
                    $company->logo_src = $filename;
                }

                if (null === $id) {
                    $company->user_id = $user['id'];
                    $app['dbs']['mysql_write']->insert('company', $company->toArray());
                    $id = $app['dbs']['mysql_write']->lastInsertId();
                } else {
                    $app['dbs']['mysql_write']->update('company', $company->toArray(), ['id' => $id]);
                }

                return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
            }
        }

        $action = $id ? 'Edit company ' . $company->name : 'Register company here';

        return new Response($app['twig']->render('form/company_form.html.twig', [
            'message' => '',
            'form' => $form->createView(),
            'company' => $company,
            'action' => $action,
            'user' => $user
        ]));
    }

    /**
     * Check for current user review.
     *
     * @param  array   $reviews
     * @param  int     $userId
     * @return boolean
     */
    protected function checkForReview(array $reviews, int $userId)
    {
        foreach ($reviews as $review) {
            if ($review->user_id == $userId) {
                return true;
            }
        }
        return false;
    }
}
