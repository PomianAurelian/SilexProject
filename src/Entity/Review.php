<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * Review
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
}
