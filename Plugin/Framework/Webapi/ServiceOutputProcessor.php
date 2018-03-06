<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi;


class ServiceOutputProcessor
{
    /** @var \Praxigento\Core\App\Reflection\Tool\Type */
    private $hlpType;
    /** @var \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry */
    private $typePropertiesRegistry;

    public function __construct(
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry $typePropertiesRegistry,
        \Praxigento\Core\App\Reflection\Tool\Type $toolType
    ) {
        $this->typePropertiesRegistry = $typePropertiesRegistry;
        $this->hlpType = $toolType;
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
        if ($data instanceof \Praxigento\Core\Data) {
            $result = [];
            $typeData = $this->typePropertiesRegistry->register($type);
            /**
             * @var string $propertyName
             * @var \Praxigento\Core\App\Reflection\Data\Property $propertyData
             */
            foreach ($typeData as $propertyName => $propertyData) {
                $attrName = $this->camelCaseToSnakeCase($propertyName);
                $getter = 'get' . ucfirst($propertyName);
                $value = call_user_func([$data, $getter]);
                $isRequired = $propertyData->getIsRequired();
                $propertyType = $propertyData->getType();
                if ($isRequired || $value) {
                    if ($this->hlpType->isSimple($propertyType)) {
                        $result[$attrName] = $value;
                    } else {
                        // the last 2 chars will be removed for arrays
                        // in \Magento\Framework\Webapi\ServiceOutputProcessor::convertValue
                        if (is_array($value)) {
                            $propertyType = $this->hlpType->getTypeAsArrayOfTypes($propertyType);
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

    private function camelCaseToSnakeCase($data)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::camelCaseToSnakeCase($data);
        return $result;
    }
}