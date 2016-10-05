<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Analyzer;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Type_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  \Mockery\MockInterface */
    private $mToolsType;
    /** @var  Type */
    private $obj;
    /** @var array Constructor arguments for object mocking */
    private $objArgs = [];

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        $this->mToolsType = $this->_mock(\Praxigento\Core\Reflection\Tool\Type::class);
        /** reset args. to create mock of the tested object */
        $this->objArgs = [
            $this->mManObj,
            $this->mToolsType
        ];
        /** create object to test */
        $this->obj = new Type(
            $this->mManObj,
            $this->mToolsType
        );
    }

    public function test__getRequiredParamsCount()
    {
        /** === Test Data === */
        $paramsDef = '\Type $arg1, $arg2, $arg3=null';
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $res = $this->obj->_getRequiredParamsCount($paramsDef);
        $this->assertEquals(2, $res);
    }

    public function test__isSuitableMethod()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isFinal')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isConstructor')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isDestructor')->once()
            ->andReturn(false);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = 'validName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertTrue($res);
    }

    public function test__isSuitableMethod_excluded()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isFinal')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isConstructor')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isDestructor')->once()
            ->andReturn(false);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = '__invalidName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertFalse($res);
    }

    public function test__isSuitableMethod_isConstructor()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isFinal')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isConstructor')->once()
            ->andReturn(true);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = 'validName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertFalse($res);
    }

    public function test__isSuitableMethod_isDestructor()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isFinal')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isConstructor')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isDestructor')->once()
            ->andReturn(true);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = 'validName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertFalse($res);
    }

    public function test__isSuitableMethod_isFinal()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(false);
        $mMethod->shouldReceive('isFinal')->once()
            ->andReturn(true);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = 'validName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertFalse($res);
    }

    public function test__isSuitableMethod_isStatic()
    {
        /** === Test Data === */
        $mMethod = $this->_mock(\ReflectionMethod::class);
        /** === Setup Mocks === */
        // $isSuitableMethodType = (...);
        $mMethod->shouldReceive('isStatic')->once()
            ->andReturn(true);
        // $isExcludedMagicMethod = (strpos($method->getName(), '__') === 0);
        $mName = 'validName';
        $mMethod->shouldReceive('getName')->once()
            ->andReturn($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_isSuitableMethod($mMethod);
        $this->assertFalse($res);
    }

    public function test__processClassDocBlock()
    {
        /** === Test Data === */
        $mBlock = $this->_mock(\Zend\Code\Reflection\DocBlockReflection::class);
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(Type::class . '[_processClassDocLine]', $this->objArgs);
        /** === Setup Mocks === */
        // $docBlockLines = $block->getContents();
        $mLine = 'phpdoc line';
        $mBlock->shouldReceive('getContents')->once()
            ->andReturn($mLine);
        // $methodData = $this->_processClassDocLine($line);
        $mMethodData = new \Praxigento\Core\Reflection\Data\Method();
        $this->obj
            ->shouldReceive('_processClassDocLine')->once()
            ->with($mLine)
            ->andReturn($mMethodData);
        // $name = $methodData->getName();
        $mName = 'methodName';
        $mMethodData->setName($mName);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassDocBlock($mBlock);
        $this->assertEquals($mMethodData, $res[$mName]);
    }

    public function test__processClassDocLine()
    {
        /** === Test Data === */
        $returnType = '\Return\Type';
        $name = 'methodNameHere';
        $desc = 'Method description.';
        $args = '$arg1, $arg2=null';
        $argCount = 2;
        $line = "\@method $returnType|null $name($args) $desc";
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(Type::class . '[_getRequiredParamsCount]', $this->objArgs);
        /** === Setup Mocks === */
        // $paramsCount = $this->_getRequiredParamsCount($matches[3]);
        $this->obj
            ->shouldReceive('_getRequiredParamsCount')->once()
            ->with($args)
            ->andReturn($argCount);
        // $result = $this->_manObj->create(\Praxigento\Core\Reflection\Data\Method::class);
        $mResult = new \Praxigento\Core\Reflection\Data\Method();
        $this->mManObj
            ->shouldReceive('create')->once()
            ->with(\Praxigento\Core\Reflection\Data\Method::class)
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassDocLine($line);
        $this->assertEquals($name, $res->getName());
        $this->assertFalse($res->getIsRequired());
        $this->assertEquals($returnType, $res->getType());
        $this->assertEquals($desc, $res->getDescription());
        $this->assertEquals($argCount, $res->getParameterCount());
    }

    public function test__processClassDocLine_null()
    {
        /** === Test Data === */
        $line = "This is not method definition.";
        /** === Call and asserts  === */
        $res = $this->obj->_processClassDocLine($line);
        $this->assertNull($res);
    }

    public function test__processClassMethods()
    {
        /** === Test Data === */
        $method = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        $methods = [$method];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(Type::class . '[_isSuitableMethod, _processMethodDocBlock]', $this->objArgs);
        /** === Setup Mocks === */
        // $class = $method->getDeclaringClass();
        $mClass = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $method->shouldReceive('getDeclaringClass')->once()
            ->andReturn($mClass);
        // $className = $class->getName();
        $mClassName = '\Some\Other\Class';
        $mClass->shouldReceive('getName')->once()
            ->andReturn($mClassName);
        // if ($this->_isSuitableMethod($method)) {...}
        $this->obj
            ->shouldReceive('_isSuitableMethod')->once()
            ->with($method)
            ->andReturn(true);
        // $name = $method->getName();
        $mName = 'method name';
        $method->shouldReceive('getName')->once()
            ->andReturn($mName);
        // $params = $method->getNumberOfRequiredParameters();
        $mParams = 10;
        $method->shouldReceive('getNumberOfRequiredParameters')->once()
            ->andReturn($mParams);
        // $docBlock = $method->getDocBlock();
        $mDocBlock = 'php docs here';
        $method->shouldReceive('getDocBlock')->once()
            ->andReturn($mDocBlock);
        // $entry = $this->_processMethodDocBlock($docBlock);
        $mEntry = $this->_mock(\Praxigento\Core\Reflection\Data\Method::class);
        $this->obj->shouldReceive('_processMethodDocBlock')->once()
            ->with($mDocBlock)
            ->andReturn($mEntry);
        // $entry->setName($name);
        $mEntry->shouldReceive('setName')->once()
            ->with($mName);
        // $entry->setParameterCount($params);
        $mEntry->shouldReceive('setParameterCount')->once()
            ->with($mParams);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassMethods($methods);
        $this->assertEquals($mEntry, $res[$mName]);
    }

    public function test__processClassMethods_mageBase()
    {
        /** === Test Data === */
        $method = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        $methods = [$method];
        /** === Setup Mocks === */
        // $class = $method->getDeclaringClass();
        $mClass = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $method->shouldReceive('getDeclaringClass')->once()
            ->andReturn($mClass);
        // $className = $class->getName();
        $mClassName = \Praxigento\Core\Reflection\Analyzer\Type::CLASS_MAGE_BASE;
        $mClass->shouldReceive('getName')->once()
            ->andReturn($mClassName);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassMethods($methods);
        $this->assertTrue(count($res) === 0);
    }

    public function test__processClassMethods_notIsSuitable()
    {
        /** === Test Data === */
        $method = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        $methods = [$method];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(Type::class . '[_isSuitableMethod]', $this->objArgs);
        /** === Setup Mocks === */
        // $class = $method->getDeclaringClass();
        $mClass = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $method->shouldReceive('getDeclaringClass')->once()
            ->andReturn($mClass);
        // $className = $class->getName();
        $mClassName = '\Some\Other\Class';
        $mClass->shouldReceive('getName')->once()
            ->andReturn($mClassName);
        // if ($this->_isSuitableMethod($method)) {...}
        $this->obj
            ->shouldReceive('_isSuitableMethod')->once()
            ->with($method)
            ->andReturn(false);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassMethods($methods);
        $this->assertTrue(count($res) === 0);
    }

    public function test__processClassMethods_prxgtBase()
    {
        /** === Test Data === */
        $method = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        $methods = [$method];
        /** === Setup Mocks === */
        // $class = $method->getDeclaringClass();
        $mClass = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $method->shouldReceive('getDeclaringClass')->once()
            ->andReturn($mClass);
        // $className = $class->getName();
        $mClassName = \Praxigento\Core\Reflection\Analyzer\Type::CLASS_PRXGT_BASE;
        $mClass->shouldReceive('getName')->once()
            ->andReturn($mClassName);
        /** === Call and asserts  === */
        $res = $this->obj->_processClassMethods($methods);
        $this->assertTrue(count($res) === 0);
    }

    public function test__processMethodDocBlock()
    {
        /** === Test Data === */
        $docBlock = $this->_mock(\Zend\Code\Reflection\DocBlockReflection::class);
        /** === Setup Mocks === */
        // $result = $this->_manObj->create(\Praxigento\Core\Reflection\Data\Method::class);
        $mResult = new \Praxigento\Core\Reflection\Data\Method();
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mResult);
        // $returnAnnotations = $docBlock->getTags('return');
        $mReturnTag = $this->_mock(\Zend\Code\Reflection\DocBlock\Tag\ReturnTag::class);
        $docBlock->shouldReceive('getTags')->once()
            ->with('return')
            ->andReturn([$mReturnTag]);
        // $types = $returnTag->getTypes();
        $typeCommon = '\Common\Type\Name';
        $typeNull = 'null';
        $mReturnTag->shouldReceive('getTypes')->once()
            ->andReturn([$typeCommon, $typeNull]);
        // $desc = $returnTag->getDescription();
        $mDesc = 'description here';
        $mReturnTag->shouldReceive('getDescription')->once()
            ->andReturn($mDesc);
        /** === Call and asserts  === */
        $res = $this->obj->_processMethodDocBlock($docBlock);
        $this->assertEquals($mDesc, $res->getDescription());
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Reflection\Analyzer\Type::class, $this->obj);
    }

    public function test_getMethods()
    {
        /** === Test Data === */
        $type = '\Some\Type\Here';
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(Type::class . '[_processClassDocBlock, _processClassMethods]', $this->objArgs);
        /** === Setup Mocks === */
        // $typeNorm = $this->_toolsType->normalizeType($type);
        $mTypeNorm = 'normalized type';
        $this->mToolsType
            ->shouldReceive('normalizeType')->once()
            ->with($type)
            ->andReturn($mTypeNorm);
        // $reflection = $this->_manObj->create(...)
        $mReflection = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->with(\Zend\Code\Reflection\ClassReflection::class, ['argument' => $mTypeNorm])
            ->andReturn($mReflection);
        // $docBlock = $reflection->getDocBlock();
        $mDocBlock = $this->_mock(\Zend\Code\Reflection\DocBlockReflection::class);
        $mReflection->shouldReceive('getDocBlock')->once()
            ->andReturn($mDocBlock);
        // $annotatedMethods = $this->_processClassDocBlock($docBlock);
        $mAnnoMethods = [];
        $this->obj
            ->shouldReceive('_processClassDocBlock')->once()
            ->with($mDocBlock)
            ->andReturn($mAnnoMethods);
        // $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $mPubMethods = [];
        $mReflection->shouldReceive('getMethods')->once()
            ->with(\ReflectionMethod::IS_PUBLIC)
            ->andReturn($mPubMethods);
        // $generalMethods = $this->_processClassMethods($publicMethods);
        $mItem = new \Praxigento\Core\Reflection\Data\Method();
        $mGeneralMethods = [$mItem];
        $this->obj->shouldReceive('_processClassMethods')->once()
            ->with($mPubMethods)
            ->andReturn($mGeneralMethods);
        // $item->get...
        $aName = 'method name';
        $aType = 'method type';
        $aDesc = 'method comments';
        $aParams = 2;
        $mItem->setName($aName);
        $mItem->setType($aType);
        $mItem->setIsRequired(true);
        $mItem->setDescription($aDesc);
        $mItem->setParameterCount($aParams);
        /** === Call and asserts  === */
        $res = $this->obj->getMethods($type);
        $this->assertArrayHasKey($aName, $res);
        $entry = $res[$aName];
        $this->assertArrayHasKey('type', $entry);
        $this->assertArrayHasKey('isRequired', $entry);
        $this->assertArrayHasKey('description', $entry);
        $this->assertArrayHasKey('parameterCount', $entry);
    }
}