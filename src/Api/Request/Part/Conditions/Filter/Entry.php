<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Request\Part\Conditions\Filter;

/**
 * Filtering entry (standalone filter).
 */
class Entry
    extends \Flancer32\Lib\Data
{

    /**
     * Set of attributes/values to be used in the filter expression.
     *
     * @return string[]|null
     */
    public function getArgs()
    {
        $result = parent::getArgs();
        return $result;
    }

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
     * Function/operation to use in the filter expression.
     *
     * @return string
     */
    public function getFunc()
    {
        $result = parent::getFunc();
        return $result;
    }

    /**
     * Single value to be used in the filter expression.
     *
     * @return string|null
     */
    public function getValue()
    {
        $result = parent::getValue();
        return $result;
    }

    /**
     * Set of attributes/values to be used in the filter expression.
     *
     * @param string[] $data
     */
    public function setArgs($data)
    {
        parent::setArgs($data);
    }

    /**
     * Name of the attribute in result set.
     *
     * @param string $data
     */
    public function setAttr($data)
    {
        parent::setAttr($data);
    }

    /**
     * Function/operation to use in the filter expression.
     *
     * @param string $data
     */
    public function setFunc($data)
    {
        parent::setFunc($data);
    }

    /**
     * Single value to be used in the filter expression.
     *
     * @param string $data
     */
    public function setValue($data)
    {
        parent::setValue($data);
    }
}