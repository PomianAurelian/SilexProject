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
	 * @var int(10)
	 */
	public $description;
	/**
	 * @var varchar(255)
	 */
	public $logo_src;
	/**
	 * @var ENUM('A', 'B', 'C')
	 */
	public $radio_choice;
	/**
	 * @var int
	 */
	public $average_rating;
	
	public function setFromArray($array) 
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

}