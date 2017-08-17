<?php

namespace Repository;

use Silex\Application;
use Entity\Category;

/**
 * Category Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class CategoryRepository
{
	/**
	 * @var Application
	 */
	protected $app;

	/**
	 * Constructor
	 * @param Application 	$app
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Find all categories.
	 *
	 * @return Category[]
	 */
	public function findAll()
	{
		$sql = "SELECT * FROM category";
    	$categoriesArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($categoriesArr);
	}

	/**
	 * Convert categories from array form to object form.
	 *
	 * @param  array[] 		$categoriesArr
	 * @return Category[]
	 */
	protected function convertArraysToObjects($categoriesArr)
	{
		$objects = [];
		foreach ($categoriesArr as $cat) {
			$category = new Category();
			$category->setFromArray($cat);
			$objects[] = $category;
		}
		return $objects;
	}
}
