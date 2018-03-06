<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Ui\DataProvider\Grid\Query;

/**
 * Base class to create grid query builders.
 */
abstract class Builder
    implements \Praxigento\Core\App\Ui\DataProvider\Grid\Query\IBuilder
{

    /**
     * Default connection.
     *
     * @var  \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $conn;
    /**
     * Adopts SearchCriteria to SQL queries.
     *
     * @var \Praxigento\Core\App\Repo\Query\Criteria\IAdapter
     */
    protected $critAdapter;
    /**
     * Map query aliases into "table"."column" pairs.
     *
     * @var  \Praxigento\Core\App\Repo\Query\Criteria\IMapper
     */
    protected $mapper;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\App\Repo\Query\Criteria\IAdapter $critAdapter
    )
    {
        $this->resource = $resource;
        $this->conn = $resource->getConnection();
        $this->critAdapter = $critAdapter;
    }

    public function getItems(\Magento\Framework\Api\Search\SearchCriteriaInterface $search)
    {
        /** @var \Magento\Framework\DB\Select $query */
        $query = $this->getQueryItems();
        /* set where */
        $where = $this->critAdapter->getWhereFromApiCriteria($search, $this->getMapper());
        $query->where($where);
        /* set order */
        $order = $this->critAdapter->getOrderFromApiCriteria($search);
        $query->order($order);
        /* limit pages */
        $pageSize = $search->getPageSize();
        $pageIndx = $search->getCurrentPage();
        $query->limitPage($pageIndx, $pageSize);
        $result = $this->conn->fetchAll($query);
        return $result;
    }

    /**
     * Mapper to be used with $this->critAdpter
     *
     * @return \Praxigento\Core\App\Repo\Query\Criteria\IMapper
     */
    abstract protected function getMapper();

    /**
     * Get query to select items for the grid.
     *
     * @return \Magento\Framework\DB\Select
     */
    abstract protected function getQueryItems();

    /**
     * Get query to select total count for the grid.
     *
     * @return \Magento\Framework\DB\Select
     */
    abstract protected function getQueryTotal();

    public function getTotal(\Magento\Framework\Api\Search\SearchCriteriaInterface $search)
    {
        /* get query to select totals */
        /** @var \Magento\Framework\DB\Select $query */
        $query = $this->getQueryTotal();
        /* ... then add filter only (w/o limits) */
        $where = $this->critAdapter->getWhereFromApiCriteria($search, $this->getMapper());
        $query->where($where);
        $conn = $query->getConnection();
        /* fetch one result */
        $result = $conn->fetchOne($query);
        return $result;
    }
}