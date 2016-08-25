<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Reflection;

/**
 * Filter DataObject specific methods in DO2JSON conversion.
 *
 * \Magento\Framework\Reflection\FieldNamer
 */
class FieldNamer
{
    /**#@+
     * Names of the methods to skip (universal DataObjects methods).
     */
    const BASE_GETTER = 'getData';
    const BASE_ITERATOR = 'getIterator';
    const BASE_SETTER = 'setData';
    const BASE_UN_SETTER = 'unsetData';
    /**#@-*/

    /**
     * @param \Magento\Framework\Reflection\FieldNamer $subject
     * @param \Closure $proceed
     * @param string $methodName
     * @return string|null
     */
    public function aroundGetFieldNameForMethodName(
        \Magento\Framework\Reflection\FieldNamer $subject,
        \Closure $proceed,
        $methodName
    ) {
        if (
            ($methodName == self::BASE_GETTER) ||
            ($methodName == self::BASE_SETTER) ||
            ($methodName == self::BASE_UN_SETTER) ||
            ($methodName == self::BASE_ITERATOR)
        ) {
            $result = null;
        } else {
            $result = $proceed($methodName);
        }
        return $result;
    }
}