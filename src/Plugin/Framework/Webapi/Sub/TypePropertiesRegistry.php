<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

/**
 *
 */
class TypePropertiesRegistry
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

    /**
     * Analyze documentation and extract annotated properties.
     *
     * @param string $type Normalized type name.
     * @param \Zend\Code\Reflection\DocBlockReflection $block Documentation block.
     */
    public function _processDocBlock($type, \Zend\Code\Reflection\DocBlockReflection $block)
    {
        if ($block) {
            /* process annotated methods */
            $docBlockLines = $block->getContents();
            $docBlockLines = explode("\n", $docBlockLines);
            foreach ($docBlockLines as $line) {
                $paramData = $this->_processDocLine($line);
                if ($paramData) {
                    $attrName = $paramData->getName();
                    $attrType = $paramData->getType();
                    $this->_registry[$type][$attrName] = $paramData;
                    $this->register($attrType);
                }
            }
        }
    }

    /**
     * @param string $type Normalized type name.
     * @param \Zend\Code\Reflection\MethodReflection[] $methods reflection of the type's methods.
     */
    public function _processMethods($type, $methods)
    {
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $isGetter = (strpos($methodName, 'get') === 0);
            /* only getters w/o parameters will be proceeded */
            if ($isGetter && !$method->getNumberOfParameters() && $methodName != 'getIterator') {
                $attrName = lcfirst(substr($methodName, 3));
                $typeData = $this->_typeProcessor->getGetterReturnType($method);
                $attrType = $typeData['type'];
                $propData = new PropertyData();
                $propData->setName($attrName);
                $propData->setIsRequired($typeData['isRequired']);
                $propData->setType($attrType);
                $this->_registry[$type][$attrName] = $propData;
                $this->register($attrType);
            }
        }
    }

    /**
     * Analyze documentation line and extract property data according to getter's pattern.
     * @param string $line
     * @return PropertyData|null
     */
    public function _processDocLine($line)
    {
        $result = null;
        if (preg_match(self::PATTERN_METHOD_GET, $line, $matches)) {
            $attrRequired = true;
            $attrType = $matches[1];
            $attrName = lcfirst($matches[2]);
            if (substr($attrType, -0, strlen('|null'))) {
                $attrType = str_replace('|null', '', $attrType);
                $attrRequired = false;
            }
            $result = new PropertyData();
            $result->setName($attrName);
            $result->setIsRequired($attrRequired);
            $result->setType($attrType);
        }
        return $result;
    }

    /**
     * All types names should be absolute (include namespace) in the registry.
     * First '\' will be removed if exists.
     * Array types (\Some\Type[]) will be converted into simple types (Some\Type).
     * Simple types names will be converted to it's canonical versions (bool => boolean).
     */
    public function normalizeType($type)
    {
        $result = $this->_typeProcessor->normalizeType($type);
        if ($result && $result[0] == '\\') {
            $result = substr($result, 1); // remove leading slash
        }
        if (strstr($result, '[]')) {
            $result = substr($result, 0, -2); // remove '[]' at the end
        }
        return $result;
    }

    /**
     * Analyze $type and save type properties into the registry.
     *
     * @param string $type
     * @return PropertyData[] array with type properties or empty array for simple types.
     */
    public function register($type)
    {
        $typeNorm = $this->normalizeType($type); // strip leading slash if exist
        $isSimple = $this->_typeProcessor->isTypeSimple($typeNorm);
        if (!isset($this->_registry[$typeNorm])) {
            if (!$isSimple) {
                /* analyze properties for complex type */
                $this->_registry[$typeNorm] = [];
                /* process annotated methods */
                $reflection = new \Zend\Code\Reflection\ClassReflection($typeNorm);
                $docBlock = $reflection->getDocBlock();
                $this->_processDocBlock($typeNorm, $docBlock);
                /* process normal methods (not annotated) */
                $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                $this->_processMethods($typeNorm, $methods);
            } else {
                /* this is simple type w/o props */
                $this->_registry[$typeNorm] = [];
            }
        }
        return $this->_registry[$typeNorm];
    }
}