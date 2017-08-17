<?php

namespace Repository;

use Silex\Application;

/**
 * Base Repository
 *
 * @author  Pomian Ghe. Aurelian
 */
abstract class BaseRepository
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

    /**
     * Find all records.
     *
     * @return Record[]
     */
    public function findAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName();
        $recordsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);

        return $this->convertArraysToObjects($recordsArr);
    }

    /**
     * Find record by id.
     *
     * @param  int    $id
     * @return Record
     */
    public function find(int $id)
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id = ?";
        $recordsArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql, [(int) $id]);
        return $this->convertArrayToObject($recordsArr);
    }

    /**
     * Convert records from array to object.
     *
     * @param  array[]  $arrays
     * @return Record[]
     */
    protected function convertArraysToObjects(array $arrays)
    {
        $objects = [];

        foreach ($arrays as $array) {
            $object = $this->convertArrayToObject($array);
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Convert record from array to object.
     *
     * @param  array  $array
     * @return Record
     */
    abstract protected function convertArrayToObject(array $array);

    /**
     * Get table name.
     *
     * @return string
     */
    abstract protected function getTableName();
}
