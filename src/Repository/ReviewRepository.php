<?php

namespace Repository;

use Silex\Application;
use Entity\Review;

/**
 * Review Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class ReviewRepository
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
	 * Find all reviews.
	 *
	 * @return Review[]
	 */
	public function findAll()
	{
		$sql = "SELECT * FROM review";
    	$reviewsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($reviewsArr);
	}

	/**
	 * Find all reviews for given company id.
	 *
	 * @param  int 			$id
	 * @return Review[]
	 */
	public function findAllForThisCompanyId($id)
	{
		$sql = "SELECT * FROM review WHERE company_id = ?";
		$reviewsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $id]);
    	return $this->convertArraysToObjects($reviewsArr);
	}

	/**
	 * Get average rating for given company id.
	 *
	 * @param  int 			$id
	 * @return float
	 */
	public function getAverageRatingForThisCompanyId($id)
	{
		$sql = "SELECT AVG(rating) FROM review WHERE company_id = ?";
		$ratingsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $id]);
		return (float)$ratingsArr[0]['AVG(rating)'];
	}

	/**
	 * Convert review from array form to object form.
	 *
	 * @param  array[] 		$reviewsArr
	 * @return Review[]
	 */
	protected function convertArraysToObjects($reviewsArr)
	{
		$objects = [];
		foreach ($reviewsArr as $rev) {
			$review = new Review();
			$review->setFromArray($rev);
			$objects[] = $review;
		}
		return $objects;
	}
}

