<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query\Criteria;

/**
 * Convert API level data (grid columns) to SQL level data (table fields) for filters and orders.
 */
interface IAdapter
{
    /**
     * Extract ORDER BY clause from Magento API Criteria (Zend compatible).
     *
     * @param SearchCriteriaInterface $criteria
     * @return array|null ["FIELD ASC", ...] or null if order is missed
     */
    public function getOrderFromApiCriteria(\Magento\Framework\Api\Search\SearchCriteriaInterface $criteria);

    /**
     * Extract WHERE clause from Magento API Criteria (Zend compatible).
     *
     * @param \Magento\Framework\Api\Search\SearchCriteriaInterface $criteria
     * @param IMapper|null $mapper API2SQL fields mapper
     * @return mixed
     */
    public function getWhereFromApiCriteria(
        \Magento\Framework\Api\Search\SearchCriteriaInterface $criteria,
        \Praxigento\Core\Repo\Query\Criteria\IMapper $mapper = null
    );

}