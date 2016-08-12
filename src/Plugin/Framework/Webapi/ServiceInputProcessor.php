<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;

/**
 * Plugin to process annotated data objects.
 */
class ServiceInputProcessor
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_objectManager;
    /** @var  \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser */
    protected $_parser;
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;
    /** @var Sub\TypePropertiesRegistry */
    protected $_typePropsRegistry;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry $typePropsRegistry,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser $parser
    ) {
        $this->_objectManager = $objectManager;
        $this->_typeProcessor = $typeProcessor;
        $this->_typePropsRegistry = $typePropsRegistry;
        $this->_parser = $parser;
    }

    /**
     * Add separate flow for annotated data objects, all other objects are processed by original code.
     *
     * @param \Magento\Framework\Webapi\ServiceInputProcessor $subject
     * @param \Closure $proceed
     * @param $data
     * @param $type
     * @return mixed
     */
    public function aroundConvertValue(
        \Magento\Framework\Webapi\ServiceInputProcessor $subject,
        \Closure $proceed,
        $data,
        $type
    ) {
        $result = null;
        if (is_subclass_of($type, \Flancer32\Lib\DataObject::class)) {
            if (
                $this->_typeProcessor->isTypeSimple($type) ||
                $this->_typeProcessor->isTypeAny($type)
            ) {
                $result = $this->_typeProcessor->processSimpleAndAnyType($data, $type);
            } else {
                /** Complex type or array of complex types */
                $isArrayType = $this->_typeProcessor->isArrayType($type);
                if ($isArrayType) {
                    // Initializing the result for array type else it will return null for empty array
                    $itemType = $this->_typeProcessor->getArrayItemType($type);
                    if (is_array($data)) {
                        $result = [];
                        foreach ($data as $key => $item) {
                            $result[$key] = $this->_parser->parseArrayData($itemType, $item);
                        }
                    }
                } else {
                    $result = $this->_parser->parseArrayData($type, $data);
                }
            }
        } else {
            $result = $proceed($data, $type);
        }
        return $result;
    }
}