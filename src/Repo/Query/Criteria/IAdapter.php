<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query\Criteria;

use Magento\Framework\Api\Search\SearchCriteriaInterface;

interface IAdapter
{
    /**
     * Extract ORDER BY clause from Magento API Criteria (Zend compatible).
     *
     * @param SearchCriteriaInterface $criteria
     * @return array|null ["FIELD ASC", ...] or null if order is missed
     */
    public function getOrderFromApiCriteria(SearchCriteriaInterface $criteria);

    /**
     * Extract WHERE clause from Magento API Criteria (Zend compatible).
     *
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getWhereFromApiCriteria(SearchCriteriaInterface $criteria);
}