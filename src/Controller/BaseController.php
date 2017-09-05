<?php

namespace Controller;

use Silex\Application;
use Entity\User;

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
        $aux = $app['session']->get('user');
        if (null !== $aux){
            $user = new User();
            $user->setFromArray($aux);
        } else {
            $user = null;
        }

        return $user;
    }
}
