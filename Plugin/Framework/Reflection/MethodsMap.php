<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Reflection;

/**
 * Replace Magento mapper to get full methods map (including annotated) used in DO2JSON conversion.
 *
 * \Magento\Framework\Reflection\MethodsMap
 */
class MethodsMap
{
    /**
     * Praxigento mapper to parse types consider annotated methods.
     *
     * @var \Praxigento\Core\App\Reflection\Map\Methods
     */
    protected $_mapMethods;


    public function __construct(
        \Praxigento\Core\App\Reflection\Map\Methods $mapMethods
    ) {
        $this->_mapMethods = $mapMethods;
    }

    /**
     * Replace Magento mapping by own.
     *
     * @param \Magento\Framework\Reflection\MethodsMap $subject
     * @param \Closure $proceed
     * @param $interfaceName
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetMethodsMap(
        \Magento\Framework\Reflection\MethodsMap $subject,
        \Closure $proceed,
        $interfaceName
    ) {
        // $orig = $proceed($interfaceName); TODO: remove if not used
        $result = $this->_mapMethods->getMap($interfaceName);
        return $result;
    }
}