<?php

namespace Entity;

use Entity\Category;
use Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

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
	 * @var int(10)
	 */
	public $radioBtn_id;
	/**
	 * @var varchar(255)
	 */
	public $logo_src;
	/**
	 * @var ENUM('A', 'B', 'C')
	 */
	public $radio_choice;

	public function setFromArray($array)
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function setToArray()
	{
		$array = [];
		foreach ($this as $key => $value) {
			$array[$key] = $value;
		}
		return $array;
	}

}
