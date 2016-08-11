<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class TypePropertiesRegistry_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mTypeProcessor;
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  TypePropertiesRegistry */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mockObjectManager();
        $this->mTypeProcessor = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        /** create object to test */
        $this->obj = new TypePropertiesRegistry(
            $this->mManObj,
            $this->mTypeProcessor
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry::class, $this->obj);
    }

    public function test_processDocBlock()
    {
        /** === Test Data === */
        $TYPE = 'type name';
        $CONTENTS = "line1\nline2";
        $PROP_TYPE = 'property type';
        $PROP_DATA = new PropertyData();
        $PROP_DATA->setName('name');
        $PROP_DATA->setIsRequired(true);
        $PROP_DATA->setType($PROP_TYPE);
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(TypePropertiesRegistry::class . '[_processDocLine, register]', [
            $this->mManObj,
            $this->mTypeProcessor
        ]);
        /** === Setup Mocks === */
        $mBlock = $this->_mock(\Zend\Code\Reflection\DocBlockReflection::class);
        // $docBlockLines = $block->getContents();
        $mBlock
            ->shouldReceive('getContents')->once()
            ->andReturn($CONTENTS);
        // $propData = $this->_processDocLine($line);
        $this->obj
            ->shouldReceive('_processDocLine')->once()
            ->andReturn($PROP_DATA);
        // $this->register($propType);
        $this->obj
            ->shouldReceive('register')->once()
            ->with($PROP_TYPE);
        /** === Call and asserts  === */
        $this->obj->_processDocBlock($TYPE, $mBlock);
    }

    public function test_processDocLine()
    {
        /** === Test Data === */
        $TYPE = '\Type\Name\Here';
        $TYPE_NORM = 'Type\Name\Here';
        $NAME = 'SomeData';
        $LINE = "@method $TYPE|null get$NAME() Comment.";
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(TypePropertiesRegistry::class . '[normalizeType]', [
            $this->mManObj,
            $this->mTypeProcessor
        ]);
        /** === Setup Mocks === */
        // $propType = $this->normalizeType($propType);
        $this->obj
            ->shouldReceive('normalizeType')->once()
            ->with($TYPE)
            ->andReturn($TYPE_NORM);
        /** === Call and asserts  === */
        $res = $this->obj->_processDocLine($LINE);
        $this->assertEquals($TYPE_NORM, $res->getType());
        $this->assertEquals(lcfirst($NAME), $res->getName());
        $this->assertFalse($res->getIsRequired());

    }

    public function test_processMethods()
    {
        /** === Test Data === */
        $TYPE = 'Type\Name\Here';
        $PROP_NAME = 'someProperty';
        $PROP_TYPE = 'Property\Type\Here';
        $PROP_TYPE_FULL = '\\' . $PROP_TYPE;
        $METHOD_NAME = 'get' . ucfirst($PROP_NAME);
        $mMethod = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        $METHODS = [$mMethod];
        $TYPE_DATA = ['type' => $PROP_TYPE_FULL, 'isRequired' => true];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(TypePropertiesRegistry::class . '[normalizeType,register]', [
            $this->mManObj,
            $this->mTypeProcessor
        ]);
        /** === Setup Mocks === */
        // $methodName = $method->getName();
        $mMethod
            ->shouldReceive('getName')->once()
            ->andReturn($METHOD_NAME);
        // $hasParams = $method->getNumberOfParameters() > 0;
        $mMethod
            ->shouldReceive('getNumberOfParameters')->once()
            ->andReturn(0);
        // $typeData = $this->_typeProcessor->getGetterReturnType($method);
        $this->mTypeProcessor
            ->shouldReceive('getGetterReturnType')->once()
            ->andReturn($TYPE_DATA);
        // $propType = $this->normalizeType($propType);
        $this->obj
            ->shouldReceive('normalizeType')->once()
            ->with($PROP_TYPE_FULL)
            ->andReturn($PROP_TYPE);
        // $this->register($propType);
        $this->obj
            ->shouldReceive('register')->once()
            ->with($PROP_TYPE);
        /** === Call and asserts  === */
        $this->obj->_processMethods($TYPE, $METHODS);
    }

    public function test_normalizeType()
    {
        /** === Test Data === */
        $TYPE_FULL = '\Some\Type\Here[]';
        $TYPE = 'Some\Type\Here';
        /** === Setup Mocks === */
        // $result = $this->_typeProcessor->normalizeType($type);
        $this->mTypeProcessor
            ->shouldReceive('normalizeType')->once()
            ->andReturn($TYPE_FULL);
        /** === Call and asserts  === */
        $res = $this->obj->normalizeType($TYPE_FULL);
        $this->assertEquals($TYPE, $res);
    }

    public function test_register_complex()
    {
        /** === Test Data === */
        $TYPE_FULL = '\Some\Type\Here[]';
        $TYPE = 'Some\Type\Here';
        $METHODS = ['method data'];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(TypePropertiesRegistry::class . '[normalizeType,_processDocBlock,_processMethods]',
            [
                $this->mManObj,
                $this->mTypeProcessor
            ]);
        /** === Setup Mocks === */
        // $typeNorm = $this->normalizeType($type);
        $this->obj
            ->shouldReceive('normalizeType')->once()
            ->with($TYPE_FULL)
            ->andReturn($TYPE);
        // $isSimple = $this->_typeProcessor->isTypeSimple($typeNorm);
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->with($TYPE)
            ->andReturn(false);
        // $reflection = $this->_manObj->create(\Zend\Code\Reflection\ClassReflection::class, [$typeNorm]);
        $mReflection = $this->_mock(\Zend\Code\Reflection\ClassReflection::class);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn($mReflection);
        // $docBlock = $reflection->getDocBlock();
        $mDocBlock = $this->_mock(\Zend\Code\Reflection\DocBlockReflection::class);
        $mReflection
            ->shouldReceive('getDocBlock')->once()
            ->andReturn($mDocBlock);
        // $this->_processDocBlock($typeNorm, $docBlock);
        $this->obj
            ->shouldReceive('_processDocBlock')->once();
        // $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $mReflection
            ->shouldReceive('getMethods')->once()
            ->andReturn($METHODS);
        // $this->_processMethods($typeNorm, $methods);
        $this->obj
            ->shouldReceive('_processMethods')->once();
        /** === Call and asserts  === */
        $res = $this->obj->register($TYPE_FULL);
        $this->assertTrue(is_array($res));
    }
    public function test_register_simple()
    {
        /** === Test Data === */
        $TYPE_FULL = '\Some\Type\Here[]';
        $TYPE = 'Some\Type\Here';
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(TypePropertiesRegistry::class . '[normalizeType,_processDocBlock,_processMethods]',
            [
                $this->mManObj,
                $this->mTypeProcessor
            ]);
        /** === Setup Mocks === */
        // $typeNorm = $this->normalizeType($type);
        $this->obj
            ->shouldReceive('normalizeType')->once()
            ->with($TYPE_FULL)
            ->andReturn($TYPE);
        // $isSimple = $this->_typeProcessor->isTypeSimple($typeNorm);
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->with($TYPE)
            ->andReturn(true);
        /** === Call and asserts  === */
        $res = $this->obj->register($TYPE_FULL);
        $this->assertTrue(is_array($res));
    }
}