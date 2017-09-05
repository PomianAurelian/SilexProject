<?php

namespace Repository;

use Silex\Application;
use Entity\User;
use Repository\BaseRepository;

/**
 * User Repository
 *
 * @see BaseRepository
 *
 * @author Pomian Ghe. Aurelian
 */
class UserRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getTableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewEntityInstance()
    {
        return new User();
    }
}

