<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Rewrite\Framework\Reflection;

use Zend\Code\Reflection\MethodReflection;

/**
 * Override "\Magento\Framework\Reflection\TypeProcessor" to add parsing of the annotated accessors (get/set methods) for MOBI app.
 */
class TypeProcessor
    extends \Magento\Framework\Reflection\TypeProcessor
{
    const PATTERN_METHOD_GET = "/\@method\s+(.+)\s+get(.+)\(\)\s*(.*)/";
    const PATTERN_NULL = '|null';
    const LEN_NULL = 5;
    const SKIP_DATA = 'getData';
    const SKIP_ITERATOR = 'getIterator';
    /**
     * Full names of the types for the internal registry.
     */
    const TYPE_ARRAY_ITERATOR = '\ArrayIterator';

    /** @inheritdoc */
    protected function _processComplexType($class)
    {
        /* run parent method to analyze coded methods */
        $result = parent::_processComplexType($class);
        /* this is parent code w/o processed coded methods with own code to process annotated */
        $typeName = $this->translateTypeName($class);
        if (!$this->isArrayType($class)) {
            $reflection = new \Zend\Code\Reflection\ClassReflection($class);
            $docBlock = $reflection->getDocBlock();
            if ($docBlock) {
                $docBlockLines = $docBlock->getContents();
                $docBlockLines = explode("\n", $docBlockLines);
                foreach ($docBlockLines as $line) {
                    if (preg_match(self::PATTERN_METHOD_GET, $line, $matches)) {
                        $attrRequired = true;
                        $attrType = $matches[1];
                        $attrName = lcfirst($matches[2]);
                        $documentation = $matches[3];
                        $lenType = strlen($attrType);
                        if (substr($attrType, $lenType - self::LEN_NULL) == self::PATTERN_NULL) {
                            $attrType = str_replace(self::PATTERN_NULL, '', $attrType);
                            $attrRequired = false;
                        }
                        /* see docs for \Magento\Framework\Reflection\TypeProcessor::$_types */
                        $this->_types[$typeName]['parameters'][$attrName] = [
                            'type' => $this->register($attrType),
                            'required' => $attrRequired,
                            'documentation' => $documentation,
                        ];
                    }
                }
                $result = $this->_types[$typeName];
            }
        }
        return $result;
    }

    /** @inheritdoc */
    protected function _processMethod(MethodReflection $methodReflection, $typeName)
    {
        /* skip basic methods of the DataObjects */
        $name = $methodReflection->getName();
        if ($name != self::SKIP_DATA && $name != self::SKIP_ITERATOR) {
            parent::_processMethod($methodReflection, $typeName);
        }
    }

//    /** @inheritdoc */
//    public function getTypeData($typeName)
//    {
//        if ($typeName == self::TYPE_ARRAY_ITERATOR) {
//            $result = parent::getTypeData(\ArrayIterator::class);
//        } else {
//            $result = parent::getTypeData($typeName);
//        }
//        return $result;
//    }

//    /** @inheritdoc */
//    public function isTypeSimple($type)
//    {
//        $result = parent::isTypeSimple($type);
//        if ($type == self::TYPE_ARRAY_ITERATOR) {
//            if (!isset($this->_types[\ArrayIterator::class])) {
//                $this->_types[\ArrayIterator::class] = []; // class name w/o leading slash ('ArrayIterator')
//            }
//            $result = true;
//        }
//        return $result;
//    }

    /** @inheritdoc */
    public function translateTypeName($class)
    {
        try {
            $result = parent::translateTypeName($class);
        } catch (\InvalidArgumentException $e) {
            if (preg_match('/\\\\?(Praxigento)\\\\([A-Za-z0-9]*)\\\\(.*)/', $class, $matches)) {
                $moduleNamespace = 'Praxigento';
                $moduleName = $matches[2];
                $typeNameParts = explode('\\', $matches[3]);
                $result = ucfirst($moduleNamespace . $moduleName . implode('', $typeNameParts));
            }
        }
        return $result;
    }
}