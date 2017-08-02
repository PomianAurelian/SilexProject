<?php 

namespace Entity;

class Category 
{
	/**
	 * @var int 
	 */
	public $id;
	/**
	 * @var varchar(255)
	 */
	public $category;

	public function setFromArray($array) 
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}
}