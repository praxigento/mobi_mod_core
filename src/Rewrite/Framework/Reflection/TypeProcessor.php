<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Rewrite\Framework\Reflection;

/**
 * Override "\Magento\Framework\Reflection\TypeProcessor" to add parsing of the annotated accessors (get/set methods) for MOBI app.
 */
class TypeProcessor
    extends \Magento\Framework\Reflection\TypeProcessor
{
    const PATTERN_METHOD_GET = "/\@method\s+(.+)\s+get(.+)\(\)/";
    /**
     * Full names of the types for the internal registry.
     */
    const TYPE_ARRAY_ITERATOR = '\ArrayIterator';

    /**
     * Add annotation processing for accessors (get/set methods).
     *
     * @param string $class
     * @return array
     */
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
                        if (substr($attrType, -0, strlen('null'))) {
                            $attrType = str_replace('|null', '', $attrType);
                            $attrRequired = false;
                        }
                        /* see docs for \Magento\Framework\Reflection\TypeProcessor::$_types */
                        $this->_types[$typeName]['parameters'][$attrName] = [
                            'type' => $this->register($attrType),
                            'required' => $attrRequired,
                            'documentation' => 'this is annotated property (see MOBI-329).',
                        ];
                    }
                }
                $result = $this->_types[$typeName];
            }
        }
        return $result;
    }

    public function getTypeData($typeName)
    {
        if ($typeName == self::TYPE_ARRAY_ITERATOR) {
            $result = parent::getTypeData(\ArrayIterator::class);
        } else {
            $result = parent::getTypeData($typeName);
        }
        return $result;
    }

    /**
     * Expand number of simple classes.
     *
     * @param string $type
     * @return bool
     */
    public function isTypeSimple($type)
    {
        $result = parent::isTypeSimple($type);
        if ($type == self::TYPE_ARRAY_ITERATOR) {
            if (!isset($this->_types[\ArrayIterator::class])) {
                $this->_types[\ArrayIterator::class] = []; // class name w/o leading slash ('ArrayIterator')
            }
            $result = true;
        }
        return $result;
    }

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