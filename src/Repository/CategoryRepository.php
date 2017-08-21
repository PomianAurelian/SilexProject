<?php

namespace Repository;

use Silex\Application;
use Entity\Category;
use Repository\BaseRepository;

/**
 * Category Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class CategoryRepository extends BaseRepository
{
	/**
	 * {@inheritdoc}
	 */
	protected function convertArrayToObject($array)
	{
		$object = new Category();
		$object->setFromArray($array);

		return $object;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getTableName()
	{
		return 'category';
	}
}
