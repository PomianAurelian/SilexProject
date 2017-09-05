<?php

namespace Controller;

use Silex\Application;
use Entity\Review;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Repository\CompanyRepository;
use Helper\ReviewFormHelper;
use Controller\BaseController;

/**
 * Review Controller
 *
 * @see BaseController
 *
 * @author Pomian Ghe. Aurelian
 */
class ReviewController extends BaseController
{
    /**
     * Handle review form page action and request.
     * Route: /review/{id}
     *
     * @param  Application $app
     * @param  Request     $request
     * @param  int         $id
     * @return Response
     */
    public function createReviewAction(Application $app, Request $request, int $id)
    {
        $reviewFormHelper = new ReviewFormHelper($app);
        $form = $reviewFormHelper->getReviewForm($app);

        $companyRepository = new CompanyRepository($app);
        $companyCriteria['id'] = $id;
        $company = $companyRepository->findOneBy($companyCriteria);

        $user = $this->getUser($app);

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));
        }

        if ($request->isMethod('POST')) {
            $newReview = new Review();
            $newReview->setFromArray($request->request->get($form->getName()));
            $newReview->company_id = $id;

            $form->handleRequest($request);
            if ($form->isValid()) {
                $newReview->user_id = $user->id;
                $app['dbs']['mysql_read']->insert('review', $newReview->toArray());

                return $app->redirect($app["url_generator"]->generate("company_details", ['id' => $id]));
            }
        }

        return new Response($app['twig']->render('form/review_form.html.twig', [
            'form' => $form->createView(),
            'company' => $company,
            'user' => $user
        ]));
    }
}
