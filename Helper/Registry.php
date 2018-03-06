<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Praxigento\Core\Helper;


class Registry
    implements \Praxigento\Core\Api\Helper\Registry
{

    const REG_REST_INPUT = 'prxgtRestInput';
    /** @var \Magento\Framework\Registry */
    private $registry;

    public function __construct(
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * REST input parameters from Magento registry.
     *
     * @return array
     */
    public function getRestInputParams()
    {
        $result = $this->registry->registry(self::REG_REST_INPUT);
        return $result;
    }

    /**
     * Save REST input parameters into Magento registry.
     *
     * @param $data
     */
    public function setRestInputParams($data)
    {
        $oldValue = $this->registry->registry(self::REG_REST_INPUT);
        if (!is_null($oldValue)) {
            $this->registry->unregister(self::REG_REST_INPUT);
        }
        $this->registry->register(self::REG_REST_INPUT, $data);
    }

}