<?php

namespace Repository;

use Silex\Application;
use Entity\Company;
use Repository\CategoryRepository;

/**
 * Company Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class CompanyRepository
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
	 * Find all companies as arrays grouped by category.
	 *
	 * @return Company[category][]
	 */
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
		return $companyMapByCategory;
	}

	/**
	 * Find all companies.
	 *
	 * @return Company[]
	 */
	public function findAll()
	{
		$sql = "SELECT * FROM company";
    	$companiesArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($companiesArr);
	}

	/**
	 * Find company by id.
	 *
	 * @param  int 			$id
	 * @return Company
	 */
	public function findCompanyById($id)
	{
		$sql = "SELECT * FROM company WHERE id = ?";
		$companyArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql, [(int) $id]);
		return $this->convertArrayToObject($companyArr);
	}

	/**
	 * Convert company from array form to object form.
	 *
	 * @param  array 		$array
	 * @return Company
	 */
	protected function convertArrayToObject($array)
	{
		$object = new Company();
		$object->setFromArray($array);
		return $object;
	}

	/**
	 * Convert companies from array form to object form.
	 *
	 * @param  array[] 		$arrays
	 * @return Company[]
	 */
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
