<?php

namespace Service;

use Entity\User;

/**
 * User Service
 *
 * @see BaseService
 *
 * @author Pomian Ghe. Aurelian
 */
class UserService extends BaseService
{
    /**
     * Get authenticated user.
     *
     * @return User
     */
    public function getAuthenticatedUser()
    {
        $userArr = $this->app['session']->get('user');

        if (null !== $userArr) {
            $user = new User();
            $user->setFromArray($userArr);
        } else {
            $user = null;
        }

        return $user;
    }
}
