<?php

namespace Repository;

use Silex\Application;
use Entity\Company;
use Repository\CategoryRepository;

class CompanyRepository 
{	
	protected $app;

	public function __construct(Application $app) 
	{
		$this->app = $app;
	}

	public function findAllAsArraysGroupedByCategory()
	{
		$sql = "SELECT * FROM company ORDER BY category_id";
		$companiesArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
		$companiesArr = $this->convertArraysToObjects($companiesArr);
		$companyMapByCategory = [];
		
		$categoryRepository = new CategoryRepository($this->app);
		$categories = $categoryRepository->findAll();
		
		foreach($companiesArr as $company) {
			$category = '';
			foreach($categories as $cat) {
				if($cat->id === $company->category_id) {
					$category = $cat->id;
					break;
				}
			}
			$companyMapByCategory[$category][] = $company;
		}

		// echo '<pre>';
		// var_dump($companyMapByCategory);
		// echo '</pre>';
		// die;
		return $companyMapByCategory;
	}

	public function findAll() 
	{
		$sql = "SELECT * FROM company";
    	$companiesArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($companiesArr);
	}

	protected function convertArraysToObjects($arrays)
	{
		$objects = [];
		foreach ($arrays as $array) {
			$company = new Company();
			$company->setFromArray($array);
			$objects[] = $company;
		}
		return $objects;
	}


}