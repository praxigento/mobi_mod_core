<?php

/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\WebApi\Processor\WithQuery\Conditions;

/**
 * Execution context for ..\Conditions class.
 */
class Context
    extends \Praxigento\Core\Data
{
    /**
     * @return \Praxigento\Core\App\WebApi\Request\Part\Conditions|null
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

    public function setConditions(\Praxigento\Core\App\WebApi\Request\Part\Conditions $data = null)
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