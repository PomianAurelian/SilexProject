<?php

namespace Repository;

use Silex\Application;
use Entity\Review;
use Repository\BaseRepository;

/**
 * Review Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
class ReviewRepository extends BaseRepository
{
	/**
	 * Find all reviews for given company id.
	 *
	 * @param  int      $id
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
	 * @param  int   $id
	 * @return float
	 */
	public function getAverageRatingForThisCompanyId($id)
	{
		$sql = "SELECT AVG(rating) FROM review WHERE company_id = ?";
		$ratingsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $id]);
		return (float)$ratingsArr[0]['AVG(rating)'];
	}

	/**
	 * {@inheritdoc}
	 */
	protected function convertArrayToObject($array)
	{
		$object = new Review();
		$object->setFromArray($array);

		return $object;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getTableName()
	{
		return 'review';
	}
}

