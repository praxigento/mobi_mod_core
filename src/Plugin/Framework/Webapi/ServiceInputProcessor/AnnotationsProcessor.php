<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi\ServiceInputProcessor;


class AnnotationsProcessor
{
    const ATTR_NAME = 'name';
    const ATTR_REQUIRED = 'required';
    const ATTR_TYPE = 'type';
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
                            $paramData = [
                                self::ATTR_NAME => $attrName,
                                self::ATTR_TYPE => $attrType,
                                self::ATTR_REQUIRED => $attrRequired
                            ];
                            $this->_registry[$key][$attrName] = $paramData;
                            $this->register($attrType);
                        }
                    }
                }

            }
        }
        return $this->_registry[$key];
    }
}