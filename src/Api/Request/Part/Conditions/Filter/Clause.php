<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Request\Part\Conditions\Filter;

/**
 * Filtering clause (standalone filter).
 */
class Clause
    extends \Praxigento\Core\Data
{

    /**
     * Set of attributes/values to be used in the filtering expression.
     *
     * @return string[]|null
     */
    public function getArgs()
    {
        $result = parent::getArgs();
        return $result;
    }

    /**
     * Name of the attribute in the result set to be filtered.
     *
     * @return string
     */
    public function getAttr()
    {
        $result = parent::getAttr();
        return $result;
    }

    /**
     * Function/operation to use in the filtering expression.
     *
     * @return string
     */
    public function getFunc()
    {
        $result = parent::getFunc();
        return $result;
    }

    /**
     * Single value to be used in the filtering expression.
     *
     * @return string|null
     */
    public function getValue()
    {
        $result = parent::getValue();
        return $result;
    }

    /**
     * Set of attributes/values to be used in the filtering expression.
     *
     * @param string[] $data
     */
    public function setArgs($data)
    {
        parent::setArgs($data);
    }

    /**
     * Name of the attribute in the result set to be filtered.
     *
     * @param string $data
     */
    public function setAttr($data)
    {
        parent::setAttr($data);
    }

    /**
     * Function/operation to use in the filtering expression.
     *
     * @param string $data
     */
    public function setFunc($data)
    {
        parent::setFunc($data);
    }

    /**
     * Single value to be used in the filtering expression.
     *
     * @param string $data
     */
    public function setValue($data)
    {
        parent::setValue($data);
    }
}