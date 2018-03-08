<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Web;

/**
 * Base for API requests with conditions (ordering, filtering, limitations).
 *
 * (Define getters explicitly to use with Swagger tool)
 * (Define setters explicitly to use with Magento JSON2PHP conversion tool)
 *
 */
class RequestCond
    extends \Praxigento\Core\Api\App\Web\Request
{
    /**
     * Conditions (ordering, filtering, limitations).
     *
     * @return \Praxigento\Core\Api\App\Web\Request\Conditions|null
     */
    public function getConditions()
    {
        $result = parent::getConditions();
        return $result;
    }

    /**
     * Conditions (ordering, filtering, limitations).
     *
     * @param \Praxigento\Core\Api\App\Web\Request\Conditions $data
     */
    public function setConditions($data)
    {
        parent::setConditions($data);
    }

}