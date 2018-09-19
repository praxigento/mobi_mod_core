<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web\Request\Conditions\Filter;

/**
 * Filtering group. Group contains simple clauses or other groups and operand to apply ('or', 'and').
 */
class Group
    extends \Praxigento\Core\Data
{
    /**#@+
     * Operations to apply to group entries.
     */
    const OP_AND = 'AND';
    const OP_NOT = 'NOT';
    const OP_OR = 'OR';
    /**#@-  */

    /**
     * Set of groups (\Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Group)
     * or clauses (\Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Clause) to filter result set.
     *
     * @return \Praxigento\Core\Data[]
     */
    public function getEntries()
    {
        $result = parent::getEntries();
        return $result;
    }

    /**
     * Operation to apply to the group entries.
     *
     * @return string
     */
    public function getWith()
    {
        $result = parent::getWith();
        return $result;
    }

    /**
     * Set of groups (\Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Group)
     * or clauses (\Praxigento\Core\Api\App\Web\Request\Conditions\Filter\Entry) to filter result set.
     *
     * @param \Praxigento\Core\Data[] $data
     * @return void
     */
    public function setEntries($data)
    {
        parent::setEntries($data);
    }

    /**
     * Operation to apply to the group entries.
     *
     * @param string $data
     * @return void
     */
    public function setWith($data)
    {
        parent::setWith($data);
    }
}