<?php

namespace Entity;

use Entity\BaseEntity;

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
}
