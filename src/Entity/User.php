<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * User
 *
 * @see BaseEntity
 *
 * @author  Pomian Ghe. Aurelian
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
     * @var int
     */
    public $privilege;
}
