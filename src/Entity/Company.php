<?php

namespace Entity;

use Entity\Category;
use Repository\CategoryRepository;

class Company
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
	public $email;
	/**
	 * @var tinyint(1)
	 */
	public $delivery;
	/**
	 * @var int(10)
	 */
	public $category_id;
	/**
	 * @var varchar(255)
	 */
	public $logo_src;
	/**
	 * @var string
	 */
	public $radio_choice;

	public function setFromArray($array)
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function toArray()
	{
		$array = [];
		foreach ($this as $key => $value) {
			$array[$key] = $value;
		}
		return $array;
	}
}
