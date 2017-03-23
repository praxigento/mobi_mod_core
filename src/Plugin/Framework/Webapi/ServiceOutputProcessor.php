<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;


class ServiceOutputProcessor
{
    /** @var \Praxigento\Core\Tool\IConvert */
    protected $_toolConvert;
    /** @var \Praxigento\Core\Reflection\Tool\Type */
    protected $_toolType;
    /** @var \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry */
    protected $_typePropertiesRegistry;

    public function __construct(
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry $typePropertiesRegistry,
        \Praxigento\Core\Reflection\Tool\Type $toolType,
        \Praxigento\Core\Tool\IConvert $toolConvert
    ) {
        $this->_typePropertiesRegistry = $typePropertiesRegistry;
        $this->_toolType = $toolType;
        $this->_toolConvert = $toolConvert;
    }

    /**
     * Add separate flow for annotated data objects.
     *
     * @param \Magento\Framework\Webapi\ServiceOutputProcessor $subject
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
        if ($data instanceof \Flancer32\Lib\Data) {
            $result = [];
            $typeData = $this->_typePropertiesRegistry->register($type);
            /**
             * @var string $propertyName
             * @var \Praxigento\Core\Reflection\Data\Property $propertyData
             */
            foreach ($typeData as $propertyName => $propertyData) {
                $attrName = $this->_toolConvert->camelCaseToSnakeCase($propertyName);
                $getter = 'get' . ucfirst($propertyName);
                $value = call_user_func([$data, $getter]);
                $isRequired = $propertyData->getIsRequired();
                $propertyType = $propertyData->getType();
                if ($isRequired || $value) {
                    if ($this->_toolType->isSimple($propertyType)) {
                        $result[$attrName] = $value;
                    } else {
                        // the last 2 chars will be removed for arrays
                        // in \Magento\Framework\Webapi\ServiceOutputProcessor::convertValue
                        if (is_array($value)) {
                            $propertyType = $this->_toolType->getTypeAsArrayOfTypes($propertyType);
                        }
                        $result[$attrName] = $proceed($value, $propertyType);
                    }
                }
            }
        } else {
            $result = $proceed($data, $type);
        }
        return $result;
    }
}