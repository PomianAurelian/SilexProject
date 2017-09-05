<?php

namespace Repository;

use Silex\Application;

/**
 * Base Repository
 *
 * @abstract
 *
 * @author Pomian Ghe. Aurelian
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
     * Find records.
     *
     * @param  array        $criteria
     * @param  string       $order
     * @return BaseEntity[]
     */
    public function findBy(array $criteria = null, string $order = null)
    {
        $sql = "SELECT * FROM " . $this->getTableName();
        if (null !== $criteria) {
            $sql .= " WHERE ";
            $sql = $this->applyCriteria($sql, $criteria);
        }
        $sql = $this->applyOrder($sql, $order);
        $sql .= ';';

        $recordsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);
        if (0 === count($recordsArr)) {
            return null;
        }

        return $this->convertArraysToObjects($recordsArr);
    }

    /**
     * Find all records.
     *
     * @param  string        $order
     * @return BaseEntity[];
     */
    public function findAll(string $order = null)
    {
        return $this->findBy(null, $order);
    }

    /**
     * Find record by criteria.
     *
     * @param  array        $criteria
     * @return BaseEntity[]
     */
    public function findOneBy(array $criteria = null)
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE ";
        $sql = $this->applyCriteria($sql, $criteria);
        $sql .= ';';

        $recordsArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql);
        if (!$recordsArr) {
            return null;
        }

        return $this->convertArrayToObject($recordsArr);
    }

    /**
     * Apply criteria to query.
     *
     * @param  string $sql
     * @param  array  $criteria
     * @return string
     */
    protected function applyCriteria(string $sql, array $criteria = null)
    {
        if (null === $criteria) {
            return $sql;
        }
        foreach ($criteria as $key => $value) {
            $sql .= "{$key} = {$value} AND ";
        }
        $sql = substr($sql, 0, -5);
        return $sql;
    }

    /**
     * Apply order.
     *
     * @param  string $sql
     * @param  string $order
     * @return string
     */
    protected function applyOrder(string $sql, string $order = null)
    {
        if (null === $order) {
            return $sql;
        }

        $sql .= " ORDER BY " . $order;

        return $sql;
    }

    /**
     * Get new entity instance.
     *
     * @return BaseEntity
     */
    abstract protected function getNewEntityInstance();

    /**
     * Convert record from array to object.
     *
     * @param  array      $array
     * @return BaseEntity
     */
    protected function convertArrayToObject(array $array)
    {
        $object = $this->getNewEntityInstance();
        $object->setFromArray($array);

        return $object;
    }

    /**
     * Convert records from array to object.
     *
     * @param  array[]      $arrays
     * @return BaseEntity[]
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
     * Get table name.
     *
     * @return string
     */
    abstract protected function getTableName();
}
