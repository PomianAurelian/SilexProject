<?php

namespace Entity;

class Review 
{
	/**
	 * @var int 
	 */
	public $id;
	/**
	 * @var varchar(255)
	 */
	public $name;
	/**
	 * @var varchar(255)
	 */
	public $rating;
	/**
	 * @var tinyint(1)
	 */
	public $review_date;
	/**
	 * @var int(10)
	 */
	public $comment;
	/**
	 * @var int(10)
	 */
	public $company_id;

	public function setFromArray($array) 
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}
}