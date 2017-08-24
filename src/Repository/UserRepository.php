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
 * @author  Pomian Ghe. Aurelian
 */
class UserRepository extends BaseRepository
{
    /**
     * Find user by username.
     *
     * @param  string     $username
     * @return BaseEntity
     */
    public function findUser(string $username)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $userArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql, [(string) $username]);
        if (!$userArr) {
            return null;
        }

        return $this->convertArrayToObject($userArr);
    }

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

