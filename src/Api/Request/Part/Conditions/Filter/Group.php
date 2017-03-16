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

    /**
     * Operand to apply to the group entries.
     *
     * @return string
     */
    public function getWith()
    {
        $result = parent::getWith();
        return $result;
    }

    /**
     * Group entries (filters or other groups).
     *
     * @return array
     */
    public function getEntries()
    {
        $result = parent::getEntries();
        return $result;
    }

}