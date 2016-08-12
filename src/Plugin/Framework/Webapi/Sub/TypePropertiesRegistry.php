<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

/**
 * Analyze and registry types properties (annotated and generally coded).
 */
class TypePropertiesRegistry
{
    /** Pattern to extract property data from getter. */
    const PATTERN_METHOD_GET = "/\@method\s+(.+)\s+get(.+)\(\)/";
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_manObj;
    /** @var array Registry for processed types. Type name w/o leading slash is the key ("Praxigento\Core\..."). */
    protected $_registry = [];
    /** @var \Magento\Framework\Reflection\TypeProcessor */
    protected $_typeProcessor;
    /** @var \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypeTool */
    protected $_toolsType;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor,
        \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypeTool $toolsType
    ) {
        $this->_manObj = $manObj;
        $this->_typeProcessor = $typeProcessor;
        $this->_toolsType = $toolsType;
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
            $docBlockLines = $block->getContents();
            $docBlockLines = explode("\n", $docBlockLines);
            foreach ($docBlockLines as $line) {
                $propData = $this->_processDocLine($line);
                if ($propData) {
                    $propName = $propData->getName();
                    $propType = $propData->getType();
                    $this->_registry[$type][$propName] = $propData;
                    $this->register($propType);
                }
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
            $propRequired = true;
            $propType = $matches[1];
            $propName = lcfirst($matches[2]);
            if (substr($propType, -0, strlen('|null'))) {
                $propType = str_replace('|null', '', $propType);
                $propRequired = false;
            }
            $result = new PropertyData();
            $result->setName($propName);
            $result->setIsRequired($propRequired);
            $propType = $this->_toolsType->normalizeType($propType);
            $result->setType($propType);
        }
        return $result;
    }

    /**
     * Process generally coded methods ("public function getProp()").
     *
     * @param string $type Normalized type name.
     * @param \Zend\Code\Reflection\MethodReflection[] $methods Reflection of the type's methods.
     */
    public function _processMethods($type, $methods)
    {
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $isGetter = (strpos($methodName, 'get') === 0);
            $hasParams = $method->getNumberOfParameters() > 0;
            $isIterator = ($methodName == 'getIterator');
            /* only getters w/o parameters will be proceeded */
            if ($isGetter && !$hasParams && !$isIterator) {
                $propName = lcfirst(substr($methodName, 3));
                $typeData = $this->_typeProcessor->getGetterReturnType($method);
                $propType = $typeData['type'];
                $propData = new PropertyData();
                $propData->setName($propName);
                $propData->setIsRequired($typeData['isRequired']);
                $propType = $this->_toolsType->normalizeType($propType);
                $propData->setType($propType);
                $this->_registry[$type][$propName] = $propData;
                $this->register($propType);
            }
        }
    }


    /**
     * Analyze $type and save type properties into the registry.
     *
     * @param string $type
     * @return PropertyData[] array with type properties or empty array for simple types.
     */
    public function register($type)
    {
        $typeNorm = $this->_toolsType->normalizeType($type);
        $isSimple = $this->_typeProcessor->isTypeSimple($typeNorm);
        if (!isset($this->_registry[$typeNorm])) {
            if (!$isSimple) {
                /* analyze properties for complex type */
                $this->_registry[$typeNorm] = [];
                /* process annotated methods */
                /** @var \Zend\Code\Reflection\ClassReflection $reflection */
                $reflection = $this->_manObj->create(
                    \Zend\Code\Reflection\ClassReflection::class,
                    ['argument' => $typeNorm]
                );
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