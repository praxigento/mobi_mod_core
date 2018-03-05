<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Helper;

/**
 * Access MOBI related data in Magento registry.
 */
interface Registry
{
    /**
     * Get input parameters for REST operation.
     *
     * @return array
     */
    public function getRestInputParams();

    /**
     * Save input parameters for REST operation.
     *
     * see \Praxigento\Core\Plugin\Webapi\Controller\Rest\InputParamsResolver::afterResolve
     */
    public function setRestInputParams($data);
}