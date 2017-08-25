<?php

namespace Repository;

use Silex\Application;

/**
 * Base Repository
 *
 * @abstract
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
     * @param  string       $where
     * @param  string       $order
     * @return BaseEntity[]
     */
    public function findAll(string $where = null, string $order = null)
    {
        $sql = "SELECT * FROM " . $this->getTableName();
        $sql = $this->applyWhere($sql, $where);
        $sql = $this->applyOrder($sql, $order);
        $sql .= ';';

        $recordsArr = $this->app['dbs']['mysql_read']->fetchAll($sql);

        if (0 === count($recordsArr)) {
            return null;
        }

        return $this->convertArraysToObjects($recordsArr);
    }

    /**
     * Find record by id.
     *
     * @param  int        $id
     * @return BaseEntity
     */
    public function find(int $id)
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id = ?";
        $recordsArr = $this->app['dbs']['mysql_read']->fetchAssoc($sql, [(int) $id]);
        if (!$recordsArr) {
            return null;
        }

        return $this->convertArrayToObject($recordsArr);
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

        $sql .= " WHERE " . $order;

        return $sql;
    }

    /**
     * Apply where.
     *
     * @param  string $sql
     * @param  string $order
     * @return string
     */
    protected function applyWhere(string $sql, string $order = null)
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
     * Get table name.
     *
     * @return string
     */
    abstract protected function getTableName();
}
