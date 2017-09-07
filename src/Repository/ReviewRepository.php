<?php

namespace Repository;

use Silex\Application;
use Entity\Review;
use Repository\BaseRepository;

/**
 * Review Repository
 *
 * @see BaseRepository
 *
 * @author Pomian Ghe. Aurelian
 */
class ReviewRepository extends BaseRepository
{
    /**
     * Get average rating for given company id.
     *
     * @param  int   $id
     * @return float
     */
    public function getCompanyAverageRating(int $companyId)
    {
        $sql = 'SELECT AVG(rating) FROM review WHERE company_id = ?';
        $ratingsArr = $this->app['dbs']['mysql_read']->fetchAll($sql, [(int) $companyId]);

        return (float) $ratingsArr[0]['AVG(rating)'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getTableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewEntityInstance()
    {
        return new Review();
    }
}

