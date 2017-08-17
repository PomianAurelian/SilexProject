<?php

namespace Entity;

/**
 * Company
 *
 * @author  Pomian Ghe. Aurelian
 */
class Company
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
	 * @var string
	 */
	public $logo_src;
	/**
	 * @var string
	 */
	public $radio_choice;

	/**
	 * Set company from array form.
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
	 * Convert company to array form.
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
