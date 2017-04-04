<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part\Conditions\Filter;

/**
 * Filters group. Group contains simple filters or other filters groups and operand to apply ('or', 'and').
 */
class Group
    extends \Flancer32\Lib\Data
{
    /**#@+
     * Operations to apply to group entries.
     */
    const OP_AND = 'AND';
    const OP_NOT = 'NOT';
    const OP_OR = 'OR';
    /**#@-  */

    /**
     * Set of groups (\Praxigento\Core\Api\Request\Part\Conditions\Filter\Group)
     * or entries (\Praxigento\Core\Api\Request\Part\Conditions\Filter\Entry) to filter result set.
     *
     * @return \Flancer32\Lib\Data[]
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
     * Set of groups (\Praxigento\Core\Api\Request\Part\Conditions\Filter\Group)
     * or entries (\Praxigento\Core\Api\Request\Part\Conditions\Filter\Entry) to filter result set.
     *
     * @param \Flancer32\Lib\Data[] $data
     */
    public function setEntries($data)
    {
        parent::setEntries($data);
    }

    /**
     * Operation to apply to the group entries.
     *
     * @param string $data
     */
    public function setWith($data)
    {
        parent::setWith($data);
    }
}