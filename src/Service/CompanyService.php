<?php

namespace Service;

use Service\BaseService;
use Entity\Company;
use Entity\User;

/**
 * Company Service
 *
 * @see BaseService
 *
 * @author Pomian Ghe. Aurelian
 */
class CompanyService extends BaseService
{
    /**
     * Check for current user review.
     *
     * @param  Company $company
     * @param  User    $user
     * @return bool
     */
    public function userHasReview(Company $company, User $user = null)
    {
        if (null === $user) {
            return true;
        }

        $sql = 'SELECT * FROM review WHERE company_id = ' . $company->id . ' AND user_id = ' . $user->id;
        $reviewsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);

        if (0 === count($reviewsArr)) {
            return false;
        }

        return true;
    }
}
