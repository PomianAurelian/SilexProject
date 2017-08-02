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
	public $radioBtn_id;
	/**
	 * @var varchar(255)
	 */
	public $description;
	
	public function setFromArray($array) 
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function getCategory() 
	{
		$categoryRepository = new CategoryRepository($app);
		return $categoryRepository->find($this->category_id);
	}

}