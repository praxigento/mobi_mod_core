<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Request\Part\Conditions;

/**
 * Top level filter (union of the filtering clauses and/or groups of clauses).
 */
class Filter
    extends \Flancer32\Lib\Data
{

    /**
     * Single filtering clause.
     *
     * @return \Praxigento\Core\Api\Request\Part\Conditions\Filter\Clause|null
     */
    public function getClause()
    {
        $result = parent::getClause();
        return $result;
    }

    /**
     * Single group of the filtering clauses.
     *
     * @return \Praxigento\Core\Api\Request\Part\Conditions\Filter\Group
     */
    public function getGroup()
    {
        $result = parent::getGroup();
        return $result;
    }

    /**
     * Single filtering clause.
     *
     * @param \Praxigento\Core\Api\Request\Part\Conditions\Filter\Clause $data
     */
    public function setClause($data)
    {
        parent::setClause($data);
    }

    /**
     * Single group of the filtering clauses.
     *
     * @param \Praxigento\Core\Api\Request\Part\Conditions\Filter\Group $data
     */
    public function setGroup($data)
    {
        parent::setGroup($data);
    }

}