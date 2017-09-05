<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * Review
 *
 * @see BaseEntity
 *
 * @author Pomian Ghe. Aurelian
 */
class Review extends BaseEntity
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
     * @var float
     */
    public $rating;

    /**
     * @var datetime
     */
    public $review_date;

    /**
     * @var string
     */
    public $comment;

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $date = new \DateTime();
        $this->review_date = $date->format('Y-m-d H:i:s');
    }
}
