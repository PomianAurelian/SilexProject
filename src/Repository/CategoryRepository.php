<?php

namespace Repository;

use Silex\Application;
use Entity\Category;


class CategoryRepository 
{	
	protected $app;

	public function __construct(Application $app) 
	{
		$this->app = $app;
	}

	public function find($id)
	{
		$sql = "SELECT category FROM category WHERE id = ?";
    	$categoryArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql, [(int) $id]);
    	return $this->convertArraysToObjects($categoryArr);
	}

	public function findAll() 
	{
		$sql = "SELECT * FROM category";
    	$categoriesArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($categoriesArr);
	}

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