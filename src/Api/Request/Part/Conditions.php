<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part;

/**
 * Part of the request to get grid-like data (contains order, filter, pagination).
 */
class Conditions
    extends \Flancer32\Lib\Data
{
    /**
     * Filtering conditions. Condition can be
     *
     * @return \Flancer32\Lib\Data[]
     */
    public function getFilters()
    {
        $result = parent::getFilters();
        return $result;
    }

    /**
     * Number of entries in result set to return.
     *
     * @return int
     */
    public function getLimit()
    {
        $result = parent::getLimit();
        return $result;
    }

    /**
     * Offset in selected data to skip in result set.
     *
     * @return int
     */
    public function getOffset()
    {
        $result = parent::getOffset();
        return $result;
    }

    /**
     * Set of ordering conditions.
     *
     * @return \Praxigento\Core\Api\Request\Part\Conditions\Order\Entry[]
     */
    public function getOrder()
    {
        $result = parent::getOrder();
        return $result;
    }

    /**
     * Filtering conditions.
     *
     * @param \Flancer32\Lib\Data[] $data
     */
    public function setFilters($data)
    {
        parent::setFilters($data);
    }

    /**
     * Number of entries in result set to return.
     *
     * @param int $data
     */
    public function setLimit($data)
    {
        parent::setLimit($data);
    }

    /**
     * Offset in selected data to skip in result set.
     *
     * @param int $data
     */
    public function setOffset($data)
    {
        parent::setOffset($data);
    }

    /**
     * Set of ordering conditions.
     *
     * @param \Praxigento\Core\Api\Request\Part\Conditions\Order\Entry[] $data
     */
    public function setOrder($data)
    {
        parent::setOrder($data);
    }
}