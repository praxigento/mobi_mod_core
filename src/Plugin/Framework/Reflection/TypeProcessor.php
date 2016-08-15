<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Reflection;

/**
 * Allow TypeProcessor to handle DataObject & "\Praxigento\" namespace.
 */
class TypeProcessor
{
    /**
     * Allow to handle DataObject.
     *
     * @param \Magento\Framework\Reflection\TypeProcessor $subject
     * @param \Closure $proceed
     * @param $type
     * @return bool
     */
    public function aroundIsTypeSimple(
        \Magento\Framework\Reflection\TypeProcessor $subject,
        \Closure $proceed,
        $type
    ) {
        $result = $proceed($type);
        if (!$result && $type == '\ArrayIterator') {
            $result = true;
        }
        return $result;
    }

    /**
     * Add "\Praxigneto\..." namespace to available set to process classes as web service enabled.
     *
     * @param \Magento\Framework\Reflection\TypeProcessor $subject
     * @param \Closure $proceed
     * @param $class
     * @return string
     */
    public function aroundTranslateTypeName(
        \Magento\Framework\Reflection\TypeProcessor $subject,
        \Closure $proceed,
        $class
    ) {
        try {
            $result = $proceed($class);
        } catch (\InvalidArgumentException $e) {
            if (preg_match('/\\\\?(Praxigento)\\\\([A-Za-z0-9]*)\\\\(.*)/', $class, $matches)) {
                $moduleNamespace = 'Praxigento';
                $moduleName = $matches[2];
                $typeNameParts = explode('\\', $matches[3]);
                $result = ucfirst($moduleNamespace . $moduleName . implode('', $typeNameParts));
            } else {
                throw $e;
            }
        }
        return $result;
    }
}