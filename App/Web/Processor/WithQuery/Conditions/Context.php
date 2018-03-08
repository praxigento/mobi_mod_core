<?php

/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Web\Processor\WithQuery\Conditions;

/**
 * Execution context for ..\Conditions class.
 */
class Context
    extends \Praxigento\Core\Data
{
    /**
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions|null
     */
    public function getConditions()
    {
        $result = parent::getConditions();
        return $result;
    }

    /**
     * @return \Magento\Framework\DB\Select|null
     */
    public function getQuery()
    {
        $result = parent::getQuery();
        return $result;
    }

    public function setConditions(\Praxigento\Core\Api\App\Web\Request\Conditions $data = null)
    {
        parent::setConditions($data);
    }

    /**
     * @param \Magento\Framework\DB\Select $data
     */
    public function setQuery(\Magento\Framework\DB\Select $data)
    {
        parent::setQuery($data);
    }
}