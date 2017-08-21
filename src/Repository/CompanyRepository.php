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
	 * @var CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * {@inheritdoc}
	 */
	public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->categoryRepository = new CategoryRepository($this->app);
    }

	/**
	 * Find all companies as arrays grouped by category.
	 *
	 * @return Company[category][]
	 */
	public function findAllAsArraysGroupedByCategory()
	{
		$companiesArr = $this->findAll('category_id');
		$companyMapByCategory = [];

		$categories = $this->categoryRepository->findAll();

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
	protected function getTableName()
	{
		return 'company';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getNewEntityInstance()
	{
		return new Company();
	}
}
