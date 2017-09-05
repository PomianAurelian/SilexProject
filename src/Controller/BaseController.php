<?php

namespace Controller;

use Silex\Application;
use Entity\User;
use Service\UserService;

/**
 * Base Controller
 *
 * @abstract
 *
 * @author Pomian Ghe. Aurelian
 */
abstract class BaseController
{
    /**
     * Get current user.
     *
     * @param  Application $app
     * @return User
     */
    protected function getUser(Application $app)
    {
        $userService = new UserService($app);
        return $userService->getAuthenticatedUser();
    }
}
