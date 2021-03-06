<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Reflection\Analyzer;

/**
 * Type analyzer processes annotated methods.
 */
class Type
{
    const CLASS_MAGE_BASE = \Magento\Framework\Reflection\MethodsMap::BASE_MODEL_CLASS;
    const CLASS_PRXGT_BASE = \Praxigento\Core\Data::class;
    const PATTERN_METHOD = "/\@method\s+(.+)\s+(.+)\((.*)\)(.*)/";

    /** @var \Praxigento\Core\App\Reflection\Tool\Type */
    protected $toolsType;

    public function __construct(
        \Praxigento\Core\App\Reflection\Tool\Type $toolsType
    ) {
        $this->toolsType = $toolsType;
    }

    /**
     * Get count of the required parameters.
     *
     * @param $paramsDef "\Type $arg1, $arg2, $arg3=null"
     * @return int
     */
    public function _getRequiredParamsCount($paramsDef)
    {
        $result = 0;
        if ($paramsDef) {
            $result = 1;
            $commas = substr_count($paramsDef, ',');
            $equals = substr_count($paramsDef, '=');
            $result += ($commas - $equals);
        }
        return $result;
    }

    /**
     * Determines if the method is suitable to be used by the processor.
     * (see \Magento\Framework\Reflection\MethodsMap::isSuitableMethod)
     *
     * @param \ReflectionMethod $method
     * @return bool
     */
    public function _isSuitableMethod(\ReflectionMethod $method)
    {
        /* '&&' usage is shorter then '||', if first part is 'false' then all equity is false */
        $isSuitableMethodType = (
            !$method->isStatic() &&
            !$method->isFinal() &&
            !$method->isConstructor() &&
            !$method->isDestructor()
        );
        $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $result = $isSuitableMethodType && !$isExcludedMagicMethod;
        return $result;
    }

    /**
     * Analyze class documentation block and extract annotated methods.
     *
     * @param \Laminas\Code\Reflection\DocBlockReflection $block Documentation block.
     * @return \Praxigento\Core\App\Reflection\Data\Method[]
     */
    public function _processClassDocBlock($block)
    {
        $result = [];
        if ($block instanceof \Laminas\Code\Reflection\DocBlockReflection) {
            $docBlockLines = $block->getContents();
            $docBlockLines = explode("\n", $docBlockLines);
            foreach ($docBlockLines as $line) {
                $methodData = $this->_processClassDocLine($line);
                if ($methodData) {
                    $name = $methodData->getName();
                    $result[$name] = $methodData;
                }
            }
        }
        return $result;
    }

    /**
     * Analyze class level documentation line and extract method data.
     *
     * @param string $line
     * @return \Praxigento\Core\App\Reflection\Data\Method|null
     */
    public function _processClassDocLine($line)
    {
        $result = null;
        if (preg_match(self::PATTERN_METHOD, $line, $matches)) {
            /* parse and transform template's data */
            $isRequired = true;
            $returnType = $matches[1];
            /* replace '|null' in the end of the return type and mark as not required */
            $key = '|null';
            $length = strlen($key);
            if (substr($returnType, -$length, $length) == $key) {
                $returnType = str_replace($key, '', $returnType);
                $isRequired = false;
            }
            $methodName = lcfirst($matches[2]);
            $paramsCount = $this->_getRequiredParamsCount($matches[3]);
            $desc = $matches[4]??'';
            $desc = trim($desc);
            /* compose result  */
            $result = new \Praxigento\Core\App\Reflection\Data\Method();
            $result->setName($methodName);
            $result->setIsRequired($isRequired);
            $result->setType($returnType);
            $result->setDescription($desc);
            $result->setParameterCount($paramsCount);
        }
        return $result;
    }

    /**
     * @param \Laminas\Code\Reflection\MethodReflection[] $methods
     * @return \Praxigento\Core\App\Reflection\Data\Method[]
     */
    public function _processClassMethods($methods)
    {
        $result = [];
        /* see \Magento\Framework\Reflection\MethodsMap::getMethodMapViaReflection */
        foreach ($methods as $method) {
            // Include all the methods of classes inheriting from AbstractExtensibleObject.
            // Ignore all the methods of AbstractExtensibleModel's parent classes
            /** @var \Laminas\Code\Reflection\ClassReflection $class */
            $class = $method->getDeclaringClass();
            $className = $class->getName();
            if (
                ($className === self::CLASS_MAGE_BASE) ||
                ($className === self::CLASS_PRXGT_BASE)
            ) {
                // ReflectionClass::getMethods() sorts the methods by class
                // (lowest in inheritance tree first)
                // then by the order they are defined in the class definition
                break;
            }
            if ($this->_isSuitableMethod($method)) {
                $name = $method->getName();
                $params = $method->getNumberOfRequiredParameters();
                $docBlock = $method->getDocBlock();
                /** @var \Praxigento\Core\App\Reflection\Data\Method $entry */
                $entry = $this->_processMethodDocBlock($docBlock);
                $entry->setName($name);
                $entry->setParameterCount($params);
                $result[$name] = $entry;
            }
        }
        return $result;
    }

    /**
     * @param \Laminas\Code\Reflection\DocBlockReflection|false $docBlock
     * @return \Praxigento\Core\App\Reflection\Data\Method
     */
    public function _processMethodDocBlock($docBlock)
    {
        $result = new \Praxigento\Core\App\Reflection\Data\Method();
        if ($docBlock) {
            $returnAnnotations = $docBlock->getTags('return');
            if (!empty($returnAnnotations)) {
                /** @var \Laminas\Code\Reflection\DocBlock\Tag\ReturnTag $returnTag */
                $returnTag = current($returnAnnotations);
                $types = $returnTag->getTypes();
                $returnType = current($types);
                $nullable = in_array('null', $types);
                $desc = $returnTag->getDescription();
                $result->setType($returnType);
                $result->setIsRequired(!$nullable);
                $result->setDescription($desc);
            }
        }
        return $result;
    }

    /**
     * Analyze given type and return methods meta data (name, return type, description, etc.)
     *
     * @param string $type
     * @return \Praxigento\Core\App\Reflection\Data\Method[]
     */
    public function getMethods($type)
    {
        $result = [];
        if ($type !== false) {
            $typeNorm = $this->toolsType->normalizeType($type);
            /** @var \Laminas\Code\Reflection\ClassReflection $reflection */
            $reflection = new \Laminas\Code\Reflection\ClassReflection($typeNorm);
            /** @var \Laminas\Code\Reflection\DocBlockReflection $docBlock */
            $docBlock = $reflection->getDocBlock();
            $annotatedMethods = $this->_processClassDocBlock($docBlock);
            /* process normal methods (not annotated) */
            $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            $generalMethods = $this->_processClassMethods($publicMethods);
            $merged = array_merge($generalMethods, $annotatedMethods);
            /* convert results to array form according Magento requirements to be saved in the cache */
            /** @var \Praxigento\Core\App\Reflection\Data\Method $item */
            foreach ($merged as $item) {
                $methodName = $item->getName();
                $entry = [
                    'type' => $item->getType(),
                    'isRequired' => $item->getIsRequired(),
                    'description' => $item->getDescription(),
                    'parameterCount' => $item->getParameterCount()
                ];
                $result[$methodName] = $entry;
            }
        }
        return $result;
    }
}
