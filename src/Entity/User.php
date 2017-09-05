<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * User
 *
 * @see BaseEntity
 *
 * @author Pomian Ghe. Aurelian
 */
class User extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int 1-user | 2-admin | 3-super admin
     *
     */
    public $privilege;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->privilege = 1;
    }
}
