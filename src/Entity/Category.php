<?php

namespace Entity;

/**
 * Category
 *
 * @author  Pomian Ghe. Aurelian
 */
class Category
{
	/**
	 * @var int
	 */
	public $id;
	/**
	 * @var string
	 */
	public $category;

	/**
	 * Set category from array form.
	 *
	 * @param array 	$array
	 */
	public function setFromArray($array)
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}
}
