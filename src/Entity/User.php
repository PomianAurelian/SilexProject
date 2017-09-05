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
     * @const PRIVILEGE_DEFAULT
     */
    const PRIVILEGE_DEFAULT = 1;

    /**
     * @const PRRIVILEGE_ADMIN
     */
    const PRIVILEGE_ADMIN = 2;

    /**
     * @const PRRIVILEGE_SUPER_ADMIN
     */
    const PRIVILEGE_SUPER_ADMIN = 3;

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
     */
    public $privilege;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->privilege = self::PRIVILEGE_DEFAULT;
    }
}
