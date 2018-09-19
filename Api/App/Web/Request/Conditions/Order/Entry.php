<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\App\Web\Request\Conditions\Order;

/**
 * Ordering (sorting) entry.
 */
class Entry
    extends \Praxigento\Core\Data
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

    /**
     * Name of the attribute in result set.
     *
     * @param string $data
     * @return void
     */
    public function setAttr($data)
    {
        parent::setAttr($data);
    }

    /**
     * Ordering direction ('asc', 'desc').
     *
     * @param string $data
     * @return void
     */
    public function setDir($data)
    {
        parent::setDir($data);
    }
}