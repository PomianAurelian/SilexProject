<?php

namespace Repository;

use Silex\Application;
use Entity\Category;
use Repository\BaseRepository;

/**
 * Category Repository
 *
 * @see BaseRepository
 *
 * @author Pomian Ghe. Aurelian
 */
class CategoryRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getTableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewEntityInstance()
    {
        return new Category();
    }
}
