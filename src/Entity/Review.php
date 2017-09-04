<?php

namespace Entity;

use Entity\BaseEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * Load validators for review.
     *
     * @static
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('rating', new Assert\Length(array('min' => 0.5, 'max' => 5)));
        $metadata->addPropertyConstraint('comment', new Assert\NotBlank());
        $metadata->addPropertyConstraint('comment', new Assert\Length(array('min' => 10, 'max' => 200)));
    }
}
