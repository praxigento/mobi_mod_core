<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;


class AnnotationsProcessor
{
    const PATTERN_METHOD_GET = "/\@method\s+(.+)\s+get(.+)\(\)/";
    /** @var array registry for processed types. Full type name is the key ("\ArrayIterator"). */
    protected $_registry = [];
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;

    public function __construct(
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor
    ) {
        $this->_typeProcessor = $typeProcessor;
    }

    public function register($type)
    {
        $key = $type; // leading slash can be omitted
        if (!isset($this->_registry[$key])) {
            $this->_registry[$key] = [];
            if (!$this->_typeProcessor->isTypeSimple($type)) {
                $reflection = new \Zend\Code\Reflection\ClassReflection($type);
                $key = $reflection->getName();
                $docBlock = $reflection->getDocBlock();
                if ($docBlock) {
                    /* process annotated methods */
                    $docBlockLines = $docBlock->getContents();
                    $docBlockLines = explode("\n", $docBlockLines);
                    foreach ($docBlockLines as $line) {
                        if (preg_match(self::PATTERN_METHOD_GET, $line, $matches)) {
                            $attrRequired = true;
                            $attrType = $matches[1];
                            $attrName = $matches[2];
                            if (substr($attrType, -0, strlen('null'))) {
                                $attrType = str_replace('|null', '', $attrType);
                                $attrRequired = false;
                            }
                            $paramData = new PropertyData();
                            $paramData->setName($attrName);
                            $paramData->setIsRequired($attrRequired);
                            $paramData->setType($attrType);
                            $this->_registry[$key][$attrName] = $paramData;
                            $this->register($attrType);
                        }
                    }
                }
                /* process normal methods (not annotated) */
                $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                foreach ($methods as $method) {
                    $methodName = $method->getName();
                    $isGetter = (strpos($methodName, 'get') === 0);
                    /* only getters w/o parameters will be proceeded */
                    if ($isGetter && !$method->getNumberOfParameters() && $methodName != 'getIterator') {
                        $attrName = substr($methodName, 3);
                        $typeData = $this->_typeProcessor->getGetterReturnType($method);
                        $attrType = $typeData['type'];
                        $paramData = new PropertyData();
                        $paramData->setName($attrName);
                        $paramData->setIsRequired($typeData['isRequired']);
                        $paramData->setType($attrType);
                        $this->_registry[$key][$attrName] = $paramData;
                        $this->register($attrType);
                    }
                }
            }
        }
        return $this->_registry[$key];
    }
}