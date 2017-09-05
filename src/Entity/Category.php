<?php

namespace Entity;

use Entity\BaseEntity;

/**
 * Category
 *
 * @see BaseEntity
 *
 * @author Pomian Ghe. Aurelian
 */
class Category extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $category;
}
