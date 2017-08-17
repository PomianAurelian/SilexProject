<?php

namespace Repository;

use Silex\Application;
use Entity\Company;
use Repository\BaseRepository;
use Repository\CategoryRepository;

/**
 * Company Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class CompanyRepository extends BaseRepository
{
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
	 * {@inheritdoc}
	 */
	protected function convertArrayToObject($array)
	{
		$object = new Company();
		$object->setFromArray($array);

		return $object;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getTableName()
	{
		return 'company';
	}
}
