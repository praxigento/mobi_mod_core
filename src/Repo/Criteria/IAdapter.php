<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Criteria;

use Magento\Framework\Api\Search\SearchCriteriaInterface;

interface IAdapter
{
    /**
     * @param SearchCriteriaInterface $criteria
     * @return array|null ["FIELD ASC", ...] or null if order is missed
     */
    public function getOrderFromApiCriteria(SearchCriteriaInterface $criteria);

    public function getWhereFromApiCriteria(SearchCriteriaInterface $criteria);
}