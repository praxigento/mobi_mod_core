<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web\Request\Conditions;

/**
 * Top level filter (union of the filtering clauses and/or groups of clauses).
 */
class Filter
    extends \Praxigento\Core\Data
{

    /**
     * Single filtering clause.
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Clause|null
     */
    public function getClause()
    {
        $result = parent::getClause();
        return $result;
    }

    /**
     * Single group of the filtering clauses.
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Group
     */
    public function getGroup()
    {
        $result = parent::getGroup();
        return $result;
    }

    /**
     * Single filtering clause.
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Clause $data
     * @return void
     */
    public function setClause($data)
    {
        parent::setClause($data);
    }

    /**
     * Single group of the filtering clauses.
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Group $data
     * @return void
     */
    public function setGroup($data)
    {
        parent::setGroup($data);
    }

}