<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Rewrite\Framework\Reflection;


/**
 * Filter DataObject specific getters (getData & getIterator) on web services schema generation by Swagger.
 */
class TypeProcessor
    extends \Magento\Framework\Reflection\TypeProcessor
{
    const SKIP_DATA = 'getData';
    const SKIP_ITERATOR = 'getIterator';

    /** @inheritdoc */
    protected function _processMethod(
        \Zend\Code\Reflection\MethodReflection $methodReflection,
        $typeName
    ) {
        /* skip basic methods of the DataObjects */
        $name = $methodReflection->getName();
        if ($name != self::SKIP_DATA && $name != self::SKIP_ITERATOR) {
            parent::_processMethod($methodReflection, $typeName);
        }
    }
}