<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * Review
 *
 * @see BaseEntity
 *
 * @author  Pomian Ghe. Aurelian
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
     * Constructor.
     */
    public function __construct()
    {
        $this->datetime = date('Y-m-d H:i:s');
    }
}
