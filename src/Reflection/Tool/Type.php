<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Tool;

/**
 * Tools for types processing (helpers, utilities).
 */
class Type
{
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;


    public function __construct(
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor
    ) {
        $this->_typeProcessor = $typeProcessor;
    }

    /**
     * Format $name (JSON or XML) to the valid property name (camelCase with lowercase first).
     * Sample: 'json_prop_name' => 'jsonPropName'.
     *
     * @param $name
     * @return string
     */
    public function formatPropertyName($name)
    {
        $result = \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToCamelCase($name);
        return $result;
    }

    /**
     * Add 'array of' suffix to the type name (\Some\Type => \Some\Type[]).
     *
     * @param string $type
     * @return string
     */
    public function getTypeAsArrayOfTypes($type)
    {
        $result = $type . '[]';
        return $result;
    }

    /**
     * Return 'true' if $type is ended with '[]', 'false' - otherwise.
     *
     * @param string $type
     * @return bool
     */
    public function isArray($type)
    {
        $result = false;
        if (substr($type, -2) === '[]') {
            $result = true;
        }
        return $result;
    }

    /**
     * Return 'true' if $type is a simple type (string, int, ...).
     *
     * @param $type
     * @return bool
     */
    public function isSimple($type)
    {
        $result = $this->_typeProcessor->isTypeSimple($type);
        return $result;
    }

    /**
     * All types names should be absolute (include namespace) in the registry.
     * First '\' will be removed if exists.
     * Array types (\Some\Type[]) will be converted into simple types (Some\Type).
     * Simple types names will be converted to it's canonical versions (bool => boolean).
     *
     * @param string $type
     * @return string
     */
    public function normalizeType($type)
    {
        $result = $this->_typeProcessor->normalizeType($type);
        if ($result && $result[0] == '\\') {
            $result = substr($result, 1); // remove leading slash
        }
        if ($this->isArray($result)) {
            $result = substr($result, 0, -2); // remove '[]' at the end
        }
        return $result;
    }
}