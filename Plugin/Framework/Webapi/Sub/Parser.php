<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

use Praxigento\Core\Data as DataObject;

/**
 * Parse associative array and convert it into the DataObject according to given type.
 * Given type must be child of the \Praxigento\Core\Data class or simple type (string, int, ...).
 */
class Parser
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_manObj;
    /** @var \Praxigento\Core\App\Reflection\Tool\Type */
    protected $_toolType;
    /** @var \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry */
    protected $_typePropsRegistry;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry $typePropsRegistry,
        \Praxigento\Core\App\Reflection\Tool\Type $toolType
    ) {
        $this->_manObj = $manObj;
        $this->_typePropsRegistry = $typePropsRegistry;
        $this->_toolType = $toolType;
    }

    /**
     * @param string $type
     * @param array $data
     * @return DataObject|mixed
     */
    public function parseArrayData($type, $data)
    {
        $isArray = $this->_toolType->isArray($type);
        $typeNorm = $this->_toolType->normalizeType($type);
        if (is_subclass_of($typeNorm, \Praxigento\Core\Data::class)) {
            /* Process data objects separately. Register annotated class and parse parameters types. */
            if ($isArray) {
                /* process $data as array of $types */
                $result = [];
                foreach ($data as $key => $item) {
                    $result[$key] = $this->parseArrayDataRecursive($typeNorm, $item);
                }
            } else {
                /* process $data as data object of $type */
                $typeData = $this->_typePropsRegistry->register($typeNorm);
                $result = new $typeNorm(); // all data objects are w/o constructor params (Object Manager in production mode!!!!)
                foreach ($data as $key => $value) {
                    $propName = $this->_toolType->formatPropertyName($key);
                    if (isset($typeData[$propName])) {
                        /** @var \\Praxigento\Core\App\Reflection\Data\Property $propertyData */
                        $propertyData = $typeData[$propName];
                        $propertyType = $propertyData->getType();
                        $propertyIsArray = $propertyData->getIsArray();
                        if ($propertyIsArray) {
                            /* property is the array of types */
                            $propertyType = $this->_toolType->getTypeAsArrayOfTypes($propertyType);
                            $complex = $this->parseArrayDataRecursive($propertyType, $value);
                            $result->set($propName, $complex);
                        } else {
                            if ($this->_toolType->isSimple($propertyType)) {
                                /* property is the simple type */
                                $result->set($propName, $value);
                            } else {
                                /* property is the complex type, we need to convert recursively */
                                $complex = $this->parseArrayDataRecursive($propertyType, $value);
                                $result->set($propName, $complex);
                            }
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
     * This method is a wrapper to be used in the unit tests.
     *
     * @param $type
     * @param $data
     * @return DataObject|mixed
     */
    public function parseArrayDataRecursive($type, $data)
    {
        return $this->parseArrayData($type, $data);
    }

}