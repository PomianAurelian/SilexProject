<?php

namespace Service;

use Silex\Application;

/**
 * Base Service
 *
 * @abstract
 *
 * @author Pomian Ghe. Aurelian
 */
abstract class BaseService
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
