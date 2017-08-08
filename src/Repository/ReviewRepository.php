<?php

namespace Repository;

use Silex\Application;
use Entity\Review;


class ReviewRepository 
{	
	protected $app;

	public function __construct(Application $app) 
	{
		$this->app = $app;
	}

	public function findAll() 
	{
		$sql = "SELECT * FROM review";
    	$reviewsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
    	return $this->convertArraysToObjects($reviewsArr);
	}

	public function findAllForThisCompanyId($id)
	{
		$sql = "SELECT * FROM review WHERE company_id = ?";
		$reviewsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $id]);
    	return $this->convertArraysToObjects($reviewsArr);
	}

	public function getAverageRatingForThisCompanyId($id)
	{
		$sql = "SELECT AVG(rating) FROM review WHERE company_id = ?";
		$ratingsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $id]);
		return (float)$ratingsArr[0]['AVG(rating)'];
	}

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

