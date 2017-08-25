<?php

namespace Controller;

use Silex\Application;

/**
 * Base Controller
 *
 * @abstract
 *
 * @author  Pomian Ghe. Aurelian
 */
abstract class BaseController
{
    /**
     * Get current user.
     *
     * @param  Application $app
     * @return array[]
     */
    protected function getUser(Application $app)
    {
        $user = $app['session']->get('user');

        return $user;
    }
}
