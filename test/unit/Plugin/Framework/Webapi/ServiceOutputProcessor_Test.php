<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;

use \Praxigento\Core\Reflection\Data\Property;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class ServiceOutputProcessor_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mToolConvert;
    /** @var  \Mockery\MockInterface */
    private $mToolType;
    /** @var  \Mockery\MockInterface */
    private $mTypePropsRegistry;
    /** @var  ServiceOutputProcessor */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mTypePropsRegistry = $this->_mock(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry::class);
        $this->mToolType = $this->_mock(\Praxigento\Core\Reflection\Tool\Type::class);
        $this->mToolConvert = $this->_mock(\Praxigento\Core\Tool\IConvert::class);
        /** create object to test */
        $this->obj = new ServiceOutputProcessor(
            $this->mTypePropsRegistry,
            $this->mToolType,
            $this->mToolConvert
        );
    }

    public function test_aroundConvertValue_isDataObject()
    {
        /** === Test Data === */
        $ATTR_SIMPLE = 'simple_property';
        $ATTR_COMPLEX = 'complex_property';
        $PROP_SIMPLE = 'simpleProperty';
        $PROP_COMPLEX = 'complexProperty';
        $VALUE_SIMPLE = 'simple value';
        $VALUE_COMPLEX = 'complex value';
        $TYPE_SIMPLE = 'simple type';
        $TYPE_COMPLEX = 'complex type';
        $DATA = new \Flancer32\Lib\DataObject([
            $PROP_SIMPLE => $VALUE_SIMPLE,
            $PROP_COMPLEX => $VALUE_COMPLEX
        ]);
        $TYPE = \Praxigento\Core\Service\Base\Response::class;
        $TYPE_DATA = [
            $PROP_SIMPLE => new \Praxigento\Core\Reflection\Data\Property(['type' => $TYPE_SIMPLE]),
            $PROP_COMPLEX => new \Praxigento\Core\Reflection\Data\Property(['type' => $TYPE_COMPLEX])
        ];
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        /* input parameters should be transited into the wrapped method on second iteration */
        $mProceed = function ($dataIn, $typeIn) use ($VALUE_COMPLEX, $TYPE_COMPLEX) {
            $this->assertEquals($VALUE_COMPLEX, $dataIn);
            $this->assertEquals($TYPE_COMPLEX, $typeIn);
            return $VALUE_COMPLEX;
        };
        // $typeData = $this->_typePropertiesRegistry->register($type);
        $this->mTypePropsRegistry
            ->shouldReceive('register')->once()
            ->andReturn($TYPE_DATA);
        //
        //  First iteration
        //
        // $attrName = $this->_toolConvert->camelCaseToSnakeCase($propertyName);
        $this->mToolConvert
            ->shouldReceive('camelCaseToSnakeCase')->once()
            ->with($PROP_SIMPLE)
            ->andReturn($ATTR_SIMPLE);
        // if ($this->_toolType->isSimple($propertyType)) {
        $this->mToolType
            ->shouldReceive('isSimple')->once()
            ->andReturn(true);
        //
        // Second iteration
        //
        // $attrName = $this->_toolConvert->camelCaseToSnakeCase($propertyName);
        $this->mToolConvert
            ->shouldReceive('camelCaseToSnakeCase')->once()
            ->with($PROP_COMPLEX)
            ->andReturn($ATTR_COMPLEX);
        // if ($this->_toolType->isSimple($propertyType)) {
        $this->mToolType
            ->shouldReceive('isSimple')->once()
            ->andReturn(false);
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $DATA,
            $TYPE
        );
        $this->assertTrue(is_array($res));
        $this->assertEquals($VALUE_SIMPLE, $res[$ATTR_SIMPLE]);
        $this->assertEquals($VALUE_COMPLEX, $res[$ATTR_COMPLEX]);
    }

    public function test_aroundConvertValue_notDataObject()
    {
        /** === Test Data === */
        $DATA = [];
        $TYPE = '\Some\Type';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        /* input parameters should be transited into the wrapped method if $TYPE is not a DataObject */
        $mProceed = function ($dataIn, $typeIn) use ($DATA, $TYPE) {
            $this->assertEquals($DATA, $dataIn);
            $this->assertEquals($TYPE, $typeIn);
            return true;
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $DATA,
            $TYPE
        );
        $this->assertTrue($res);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\ServiceOutputProcessor::class, $this->obj);
    }
}