<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi;


use Magento\Framework\Api\SimpleDataObjectConverter;
use Praxigento\Core\Plugin\Framework\Webapi\Sub\PropertyData;

class ServiceInputProcessor
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_objectManager;
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;
    /** @var Sub\AnnotationsProcessor */
    protected $_typeProcessorAnnotated;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\AnnotationsProcessor $typeProcessorAnnotated
    ) {
        $this->_objectManager = $objectManager;
        $this->_typeProcessor = $typeProcessor;
        $this->_typeProcessorAnnotated = $typeProcessorAnnotated;
    }

    protected function _createFromArray($type, $data)
    {
        $result = $data;
        $isArray = false;
        if (substr($type, -2) === "[]") {
            $type = substr($type, 0, -2);
            $isArray = true;
        }
        if (is_subclass_of($type, \Flancer32\Lib\DataObject::class)) {
            /* Process data object separately. Register annotated class and parse parameters types. */
            $typeData = $this->_typeProcessorAnnotated->register($type);
            if ($isArray) {
                /* process $data as array of $types */
                $result = [];
                foreach ($data as $key => $item) {
                    $result[$key] = $this->_createFromArray($type, $item);
                }
            } else {
                /* process $data as data object of $type */
                $result = $this->_objectManager->create($type);
                foreach ($data as $propertyName => $value) {
                    $camelCaseProperty = SimpleDataObjectConverter::snakeCaseToCamelCase($propertyName);
                    if (isset($typeData[$camelCaseProperty])) {
                        /** @var PropertyData $propertyData */
                        $propertyData = $typeData[$camelCaseProperty];
                        $propertyType = $propertyData->getType();
                        if ($this->_typeProcessor->isTypeSimple($propertyType)) {
                            $result->setData($camelCaseProperty, $value);
                        } else {
                            $complex = $this->_createFromArray($propertyType, $value);
                            $result->setData($camelCaseProperty, $complex);
                        }
                    }
                }
            }
        } else {
            $result = $data;
        }
        return $result;
    }

    /**
     * Add separate flow for annotated data objects.
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
        if (is_subclass_of($type, \Flancer32\Lib\DataObject::class)) {
            $isArrayType = $this->_typeProcessor->isArrayType($type);
            if ($this->_typeProcessor->isTypeSimple($type) || $this->_typeProcessor->isTypeAny($type)) {
                $result = $this->_typeProcessor->processSimpleAndAnyType($data, $type);
            } else {
                /** Complex type or array of complex types */
                if ($isArrayType) {
                    // Initializing the result for array type else it will return null for empty array
                    $result = is_array($data) ? [] : null;
                    $itemType = $this->_typeProcessor->getArrayItemType($type);
                    if (is_array($data)) {
                        foreach ($data as $key => $item) {
                            $result[$key] = $this->_createFromArray($itemType, $item);
                        }
                    }
                } else {
                    $result = $this->_createFromArray($type, $data);
                }
            }
        } else {
            $result = $proceed($data, $type);
        }
        return $result;
    }
}