<?php

namespace Entity;

use Entity\BaseEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company
 *
 * @see BaseEntity
 *
 * @author Pomian Ghe. Aurelian
 */
class Company extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var bool
     */
    public $delivery;

    /**
     * @var int
     */
    public $category_id;

    /**
     * @var  string
     */
    public $description;

    /**
     * @var string
     */
    public $logo_src;

    /**
     * @var string
     */
    public $radio_choice;

    /**
     * @var int
     */
    public $user_id;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->delivery = 0;
    }

    /**
     * Load validators for company.
     *
     * @static
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('name', new Assert\Length(array('min' => 5, 'max' => 20)));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
        $metadata->addPropertyConstraint('description', new Assert\Length(array('min' => 30, 'max' => 500)));
    }
}
