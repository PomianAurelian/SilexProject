<?php

namespace Helper;

use Silex\Application;

/**
 * Base Helper
 *
 * @abstract
 *
 * @author  Pomian Ghe. Aurelian
 */
abstract class BaseHelper
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
