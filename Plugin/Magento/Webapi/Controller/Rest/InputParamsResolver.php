<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Plugin\Magento\Webapi\Controller\Rest;

/**
 * Save REST input request into Magento registry.
 */
class InputParamsResolver
{
    /** @var \Praxigento\Core\Api\Helper\Registry */
    private $hlpReg;

    public function __construct(
        \Praxigento\Core\Api\Helper\Registry $hlpReg
    ) {
        $this->hlpReg = $hlpReg;
    }

    /**
     * Save REST input request into Magento registry.
     *
     * @param \Magento\Webapi\Controller\Rest\InputParamsResolver $subject
     * @param array $result
     * @return array
     */
    public function afterResolve(
        \Magento\Webapi\Controller\Rest\InputParamsResolver $subject,
        $result
    ) {
        $this->hlpReg->setRestInputParams($result);
        return $result;
    }
}