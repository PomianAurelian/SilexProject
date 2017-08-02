<?php 

namespace Entity;

class RadioButton 
{
	/**
	 * @var int 
	 */
	public $id;
	/**
	 * @var varchar(255)
	 */
	public $choice;

	public function setFromArray($array) 
	{
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function getChoice() 
	{
		return $this->choice;
	}

}