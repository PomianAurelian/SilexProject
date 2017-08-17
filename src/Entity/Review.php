<?php

namespace Entity;

/**
 * Review
 *
 * @author  Pomian Ghe. Aurelian
 */
class Review
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
	 * Set review from array form.
	 *
	 * @param array 	$array
	 */
	public function setFromArray($array)
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	/**
	 * Convert review to array form.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
		foreach ($this as $key => $value) {
			$array[$key] = $value;
		}
		return $array;
	}
}
