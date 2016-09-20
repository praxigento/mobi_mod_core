<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query\Criteria\Def;


class Adapter
    implements \Praxigento\Core\Repo\Query\Criteria\IAdapter
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_conn = $resource->getConnection();
    }

    public function getOrderFromApiCriteria(\Magento\Framework\Api\Search\SearchCriteriaInterface $criteria)
    {
        $result = [];
        $orders = $criteria->getSortOrders();
        foreach ($orders as $item) {
            $field = $item->getField();
            $direction = $item->getDirection();
            if ($field) {
                $result[] = "$field $direction";
            }
        }
        if (!count($result) > 0) {
            $result = null;
        }
        return $result;
    }

    public function getWhereFromApiCriteria(
        \Magento\Framework\Api\Search\SearchCriteriaInterface $criteria,
        \Praxigento\Core\Repo\Query\Criteria\IMapper $mapper = null
    ) {
        $result = '';
        $filterGroups = $criteria->getFilterGroups();
        foreach ($filterGroups as $filterGroup) {
            $processed = []; // I don't know what is it "filter group" so uniquelize conditions inside one group only
            /** @var \Magento\Framework\Api\Filter $item */
            foreach ($filterGroup->getFilters() as $item) {
                $field = $item->getField();
                if ($mapper) {
                    $field = $mapper->get($field);
                }
                $cond = $item->getConditionType();
                $value = $item->getValue();
                $where = $this->_conn->prepareSqlCondition($field, [$cond => $value]);
                if (!in_array($where, $processed)) {
                    $result .= "($where) AND ";
                    $processed[] = $where;
                }
            }
        }
        $result .= '1';
        return $result;
    }

}