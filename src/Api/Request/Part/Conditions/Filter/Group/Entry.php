<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part\Conditions\Filter\Group;

/**
 * Filtering entry.
 */
class Entry
    extends \Flancer32\Lib\Data
{


    /**
     * Name of the attribute in result set.
     *
     * @return string
     */
    public function getAttr()
    {
        $result = parent::getAttr();
        return $result;
    }

    /**
     * Ordering direction ('asc', 'desc').
     *
     * @return string
     */
    public function getOper()
    {
        $result = parent::getDir();
        return $result;
    }

}