<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Parser_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  \Mockery\MockInterface */
    private $mToolType;
    /** @var  \Mockery\MockInterface */
    private $mTypePropsRegistry;
    /** @var  \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser */
    private $obj;
    /** @var array Constructor arguments for object mocking */
    private $objArgs = [];

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mockObjectManager();
        $this->mTypePropsRegistry = $this->_mock(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry::class);
        $this->mToolType = $this->_mock(\Praxigento\Core\Reflection\Tool\Type::class);
        /** reset args. to create mock of the tested object */
        $this->objArgs = [
            $this->mManObj,
            $this->mTypePropsRegistry,
            $this->mToolType
        ];
        /** create object to test */
        $this->obj = new \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser(
            $this->mManObj,
            $this->mTypePropsRegistry,
            $this->mToolType
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class, $this->obj);
    }

    public function test_parseArrayData_isDataObject_isArray()
    {
        /** === Test Data === */
        $TYPE = '\Praxigento\Core\Service\Base\Response[]';
        $TYPE_NORM = 'Praxigento\Core\Service\Base\Response';
        $TYPE_DATA = [];
        $DATA = ['data for parsing'];
        $PARSED = 'parsed item';
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(
            \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class . '[parseArrayDataRecursive]',
            $this->objArgs
        );
        /** === Setup Mocks === */
        // $isArray = $this->_toolType->isArray($type);
        $this->mToolType
            ->shouldReceive('isArray')->once()
            ->andReturn(true);
        // $typeNorm = $this->_toolType->normalizeType($type);
        $this->mToolType
            ->shouldReceive('normalizeType')->once()
            ->andReturn($TYPE_NORM);
        // $typeData = $this->_typePropsRegistry->register($typeNorm);
        $this->mTypePropsRegistry
            ->shouldReceive('register')->once()
            ->andReturn($TYPE_DATA);
        // $result[$key] = $this->parseArrayDataRecursive($typeNorm, $item);
        $this->obj
            ->shouldReceive('parseArrayDataRecursive')->once()
            ->andReturn($PARSED);
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayData($TYPE, $DATA);
        $this->assertEquals($PARSED, $res[0]);
    }

    public function test_parseArrayData_isDataObject_notArray_propsNotArrays()
    {
        /** === Test Data === */
        $KEY_CODE = 'error_code';
        $KEY_MSG = 'error_message';
        $PROP_CODE = 'errorCode';
        $PROP_MSG = 'errorMessage';
        $TYPE = '\Praxigento\Core\Service\Base\Response';
        $TYPE_NORM = 'Praxigento\Core\Service\Base\Response';
        $TYPE_DATA = [
            $PROP_CODE => new PropertyData(['type' => 'int']),
            $PROP_MSG => new PropertyData(['type' => 'complex'])
        ];
        $ERR_CODE = 32;
        $DATA = [
            $KEY_CODE => $ERR_CODE,
            $KEY_MSG => 'complex type here'
        ];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(
            \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class . '[parseArrayDataRecursive]',
            $this->objArgs
        );
        /** === Setup Mocks === */
        // $isArray = $this->_toolType->isArray($type);
        $this->mToolType
            ->shouldReceive('isArray')->once()
            ->andReturn(false);
        // $typeNorm = $this->_toolType->normalizeType($type);
        $this->mToolType
            ->shouldReceive('normalizeType')->once()
            ->andReturn($TYPE_NORM);
        $this->mTypePropsRegistry
            ->shouldReceive('register')->once()
            ->andReturn($TYPE_DATA);
        // $result = $this->_manObj->create($typeNorm);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn(new \Praxigento\Core\Service\Base\Response());
        //
        // First iteration
        //
        // $propName = $this->_toolType->formatPropertyName($key);
        $this->mToolType
            ->shouldReceive('formatPropertyName')->once()
            ->with($KEY_CODE)
            ->andReturn($PROP_CODE);
        // if ($this->_toolType->isSimple($propertyType)) {
        $this->mToolType
            ->shouldReceive('isSimple')->once()
            ->andReturn(true);
        //
        // Second iteration
        //
        // $propName = $this->_toolType->formatPropertyName($key);
        $this->mToolType
            ->shouldReceive('formatPropertyName')->once()
            ->with($KEY_MSG)
            ->andReturn($PROP_MSG);
        // if ($this->_toolType->isSimple($propertyType)) {
        $this->mToolType
            ->shouldReceive('isSimple')->once()
            ->andReturn(false);
        // $complex = $this->parseArrayDataRecursive($propertyType, $value);
        $this->obj
            ->shouldReceive('parseArrayDataRecursive')->once()
            ->andReturn('complex object here');
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayData($TYPE, $DATA);
        $this->assertTrue($res instanceof $TYPE_NORM);
        $this->assertEquals($ERR_CODE, $res->getData($PROP_CODE));
    }

    public function test_parseArrayData_isDataObject_notArray_propIsArray()
    {
        /** === Test Data === */
        $KEY_CODE = 'error_code';
        $KEY_MSG = 'error_message';
        $PROP_CODE = 'errorCode';
        $PROP_MSG = 'errorMessage';
        $TYPE = '\Praxigento\Core\Service\Base\Response';
        $TYPE_NORM = 'Praxigento\Core\Service\Base\Response';
        $PROP_TYPE = 'int';
        $PROP_TYPE_ARR = 'int[]';
        $TYPE_DATA = [
            $PROP_CODE => new PropertyData(['type' => $PROP_TYPE, 'isArray' => true])
        ];
        $ERR_CODE = 32;
        $DATA = [
            $KEY_CODE => $ERR_CODE
        ];
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(
            \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class . '[parseArrayDataRecursive]',
            $this->objArgs
        );
        /** === Setup Mocks === */
        // $isArray = $this->_toolType->isArray($type);
        $this->mToolType
            ->shouldReceive('isArray')->once()
            ->andReturn(false);
        // $typeNorm = $this->_toolType->normalizeType($type);
        $this->mToolType
            ->shouldReceive('normalizeType')->once()
            ->andReturn($TYPE_NORM);
        $this->mTypePropsRegistry
            ->shouldReceive('register')->once()
            ->andReturn($TYPE_DATA);
        // $result = $this->_manObj->create($typeNorm);
        $this->mManObj
            ->shouldReceive('create')->once()
            ->andReturn(new \Praxigento\Core\Service\Base\Response());
        // $propName = $this->_toolType->formatPropertyName($key);
        $this->mToolType
            ->shouldReceive('formatPropertyName')->once()
            ->with($KEY_CODE)
            ->andReturn($PROP_CODE);
        //  $propertyType = $this->_toolType->getTypeAsArrayOfTypes($propertyType);
        $this->mToolType
            ->shouldReceive('getTypeAsArrayOfTypes')->once()
            ->andReturn($PROP_TYPE_ARR);
        // $complex = $this->parseArrayDataRecursive($propertyType, $value);
        $this->obj
            ->shouldReceive('parseArrayDataRecursive')->once()
            ->andReturn([]);
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayData($TYPE, $DATA);
        $this->assertTrue($res instanceof $TYPE_NORM);
        $this->assertTrue(is_array($res->getData($PROP_CODE)));
    }

    public function test_parseArrayData_notDataObject()
    {
        /** === Test Data === */
        $TYPE = '\Exception';
        $TYPE_NORM = 'Exception';
        $DATA = 'data';
        /** === Setup Mocks === */
        // $isArray = $this->_toolType->isArray($type);
        $this->mToolType
            ->shouldReceive('isArray')->once()
            ->andReturn(false);
        // $typeNorm = $this->_toolType->normalizeType($type);
        $this->mToolType
            ->shouldReceive('normalizeType')->once()
            ->andReturn($TYPE_NORM);
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayData($TYPE, $DATA);
        $this->assertEquals($DATA, $res);
    }

    public function test_parseArrayDataRecursive()
    {
        /** === Test Data === */
        $TYPE_NORM = 'Exception';
        $DATA = 'data';
        $RESULT = 'result';
        /** === Mock object itself === */
        $this->obj = \Mockery::mock(
            \Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class . '[parseArrayData]',
            $this->objArgs
        );
        /** === Setup Mocks === */
        $this->obj
            ->shouldReceive('parseArrayData')->once()
            ->andReturn($RESULT);
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayDataRecursive($TYPE_NORM, $DATA);
        $this->assertEquals($RESULT, $res);
    }
}