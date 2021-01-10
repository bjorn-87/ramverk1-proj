<?php

namespace Bjos\MyActiveRecordModel;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * An implementation of the Active Record pattern to be used as
 * base class for database driven models.
 */
class MyActiveRecordModel extends ActiveRecordModel
{


    /**
     * Find and return first object found by search criteria and use
     * its data to populate this instance.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id1 = ? and id2 = ?`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return this
     */
    public function findMax() : object
    {
        $this->checkDb();
        $max = "MAX(id) AS id";
        $this->db->connect()
                 ->select($max)
                 ->from($this ->tableName)
                 ->execute()
                 ->fetchInto($this);
        return $this;
    }

    /**
     * Find and return first object found by search criteria and use
     * its data to populate this instance.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id1 = ? and id2 = ?`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return this
     */
    public function countTotal($where = null)
    {
        $this->checkDb();
        $max = "COUNT(id) as total";
        // $res = null;
        $this->db->connect()
                 ->select($max)
                 ->from($this ->tableName)
                 ->where($where)
                 ->execute()
                 ->fetchInto($this);
        return $this;
    }

    /**
     * Find and return first object found by search criteria and use
     * its data to populate this instance.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id1 = ? and id2 = ?`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return this
     */
    public function findAllPaginate($limit = 0, $offset = 1, $orderby = "id", $order = "DESC")
    {
        $this->checkDb();
        // $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                 ->select()
                 ->from($this ->tableName)
                 ->where("DELETED IS NULL")
                 ->orderBy($orderby . " " . $order)
                 ->limit($limit)
                 ->offset($offset)
                 ->execute()
                 ->fetchAllClass(get_class($this));
    }


    /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAllSelectParam($param)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select($param)
                        ->from($this->tableName)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }
}
