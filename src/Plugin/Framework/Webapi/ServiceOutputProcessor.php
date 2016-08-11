<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi;


use Praxigento\Core\Plugin\Framework\Webapi\Sub\PropertyData;

class ServiceOutputProcessor
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_objectManager;
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;
    /** @var Sub\TypePropertiesRegistry */
    protected $_typeProcessorAnnotated;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry $typeProcessorAnnotated
    ) {
        $this->_objectManager = $objectManager;
        $this->_typeProcessor = $typeProcessor;
        $this->_typeProcessorAnnotated = $typeProcessorAnnotated;
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
        \Magento\Framework\Webapi\ServiceOutputProcessor $subject,
        \Closure $proceed,
        $data,
        $type
    ) {
        if ($data instanceof \Flancer32\Lib\DataObject) {
            $result = [];
            $typeData = $this->_typeProcessorAnnotated->register($type);
            /**
             * @var string $propertyName
             * @var PropertyData $propertyData
             */
            foreach ($typeData as $propertyName => $propertyData) {
                $name = \Magento\Framework\Api\SimpleDataObjectConverter::camelCaseToSnakeCase($propertyName);
                $getterMethod = 'get' . ucfirst($propertyName);
                $value = call_user_func([$data, $getterMethod]);
                $isRequired = $propertyData->getIsRequired();
                $propertyType = $propertyData->getType();
                if ($isRequired || $value) {
                    if ($this->_typeProcessor->isTypeSimple($propertyType)) {
                        $result[$name] = $value;
                    } else {
                        $result[$name] = $proceed($value, $propertyType);
                    }
                }
            }
        } else {
            $result = $proceed($data, $type);
        }
        return $result;
    }
}