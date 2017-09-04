<?php

namespace Entity;

use Entity\BaseEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * Load validators for user.
     *
     * @static
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('username', new Assert\NotBlank());
        $metadata->addPropertyConstraint('username', new Assert\Length(array('min' => 4, 'max' => 15)));
        $metadata->addPropertyConstraint('password', new Assert\NotBlank());
        $metadata->addPropertyConstraint('password', new Assert\Length(array('min' => 6, 'max' => 15)));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());
    }
}
