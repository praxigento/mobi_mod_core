<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part\Conditions\Order;

/**
 * Ordering (sorting) entry.
 */
class Entry
    extends \Flancer32\Lib\Data
{
    const DIR_ASC = 'asc';
    const DIR_DESC = 'desc';

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
    public function getDir()
    {
        $result = parent::getDir();
        return $result;
    }

}