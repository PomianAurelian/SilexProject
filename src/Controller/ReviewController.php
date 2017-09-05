<?php

namespace Controller;

use Silex\Application;
use Entity\Review;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $company = $companyRepository->findOneBy(['id' => $id]);

        $user = $this->getUser($app);

        if (null === $user) {
            return $app->redirect($app["url_generator"]->generate("homepage"));
        }

        if (null === $company) {
            return new Response($app['twig']->render('errors/404.html.twig'));

        }

        return new Response($app['twig']->render('form/review_form.html.twig', [
            'form' => $form->createView(),
            'company' => $company
        ]));
    }

    /**
     * Handle review page form POST action and request.
     * Route: /post-review
     *
     * @param  Application $app
     * @param  Request     $request
     * @return JsonResponse
     */
    function postAction(Application $app, Request $request)
    {
        $data = (array)json_decode($request->getContent());
        $newReview = new Review();
        $newReview->setFromArray($data);
        $errors = $app['validator']->validate($newReview);
        $user = $this->getUser($app);

        if (count($errors) > 0) {
            $errorsArr = [];
            foreach ($errors as $error) {
                $errorsArr[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse([
                'success' => false,
                'errors' => $errorsArr,
                'form' => 'review'
            ]);
        } else {
            $newReview->user_id = $user->id;
            $newReview->name = $user->username;
            $app['dbs']['mysql_read']->insert('review', $newReview->toArray());

            return new JsonResponse([
                'success' => true,
                'id' => $newReview->company_id
            ]);
        }
    }
}
