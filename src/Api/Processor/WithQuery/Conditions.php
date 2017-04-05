<?php

/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Processor\WithQuery;

/**
 * Process conditions from API request and add parts to SQL query.
 */
class Conditions
{

    public function exec(\Praxigento\Core\Api\Processor\WithQuery\Conditions\Context $ctx)
    {
        /* get working vars from context */
        $query = $ctx->getQuery();
        $cond = $ctx->getConditions();

        /* perform action */
        $columns = $query->getPart(\Zend_Db_Select::COLUMNS); // get map [$tblAlias, $column, $valueAlias]
        if ($cond && $cond instanceof \Praxigento\Core\Api\Request\Part\Conditions) {
            /* we need to get reverse map: $valueAlias => [$tblAlias, $column] */
            $map = $this->mapReverse($columns);

            /* process filters */
            $filters = $cond->getFilter();
            if ($filters) {
                if ($filters->getClause()) {
                    /* there is single filtering clause in the filter */
                } elseif ($filters->getGroup()) {
                    /* there is single group of the filtering clauses in the filter */
                }
            }

            /* process limit & offset */
            $limit = (int)$cond->getLimit();
            $offset = (int)$cond->getOffset();
            if ($limit && $offset) {
                $query->limit($limit, $offset);
            } elseif ($limit) {
                $query->limit($limit);
            }


            /* process order */
            $order = $cond->getOrder();
            if (is_array($order)) {
                foreach ($order as $one) {
                    $alias = $one->getAttr();
                    $dir = $one->getDir();
                    if (strtoupper($dir) == \Zend_Db_Select::SQL_DESC) {
                        $dir = \Zend_Db_Select::SQL_DESC;
                    } else {
                        $dir = \Zend_Db_Select::SQL_ASC;
                    }
                    if (isset($map[$alias])) {
                        $pair = $map[$alias];
                        $tblAlias = $pair[0];
                        $col = $pair[1];
                        $query->order("$tblAlias.$col $dir");
                    }
                }
            }
        }

    }

    /**
     * Re-compose column information to [$valueAlias=>[$tableAlias, $column]] form.
     *
     * @param $columns
     * @return array
     */
    protected function mapReverse($columns)
    {
        $result = [];
        foreach ($columns as $one) {
            $tableAlias = $one[0];
            $column = $one[1];
            $valueAlias = $one[2];
            $result[$valueAlias] = [$tableAlias, $column];
        }
        return $result;
    }
}