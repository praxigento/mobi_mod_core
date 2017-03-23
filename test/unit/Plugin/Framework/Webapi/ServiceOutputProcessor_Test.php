<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ServiceOutputProcessor_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
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
        $attrSimple = 'simple_property';
        $attrComplex = 'complex_property';
        $propSimple = 'simpleProperty';
        $propComplex = 'complexProperty';
        $valueSimple = 'simple value';
        $valueComplex = ['complex value'];
        $typeSimple = 'simple type';
        $typeComplex = 'complex type';
        $typeComplexArr = 'complex type[]';
        $data = new \Flancer32\Lib\Data([
            $propSimple => $valueSimple,
            $propComplex => $valueComplex
        ]);
        $type = \Praxigento\Core\Service\Base\Response::class;
        $typeData = [
            $propSimple => new \Praxigento\Core\Reflection\Data\Property(['type' => $typeSimple]),
            $propComplex => new \Praxigento\Core\Reflection\Data\Property(['type' => $typeComplexArr])
        ];
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        /* input parameters should be transited into the wrapped method on second iteration */
        $mProceed = function ($dataIn, $typeIn) use ($valueComplex, $typeComplex) {
            $this->assertEquals($valueComplex, $dataIn);
            $this->assertEquals($typeComplex, $typeIn);
            return $valueComplex;
        };
        // $typeData = $this->_typePropertiesRegistry->register($type);
        $this->mTypePropsRegistry
            ->shouldReceive('register')->once()
            ->andReturn($typeData);
        //
        //  First iteration
        //
        // $attrName = $this->_toolConvert->camelCaseToSnakeCase($propertyName);
        $this->mToolConvert
            ->shouldReceive('camelCaseToSnakeCase')->once()
            ->with($propSimple)
            ->andReturn($attrSimple);
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
            ->with($propComplex)
            ->andReturn($attrComplex);
        // if ($this->_toolType->isSimple($propertyType)) {
        $this->mToolType
            ->shouldReceive('isSimple')->once()
            ->andReturn(false);
        // $propertyType = $this->_toolType->getTypeAsArrayOfTypes($propertyType);
        $this->mToolType
            ->shouldReceive('getTypeAsArrayOfTypes')->once()
            ->with($typeComplexArr)
            ->andReturn($typeComplex);
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $data,
            $type
        );
        $this->assertTrue(is_array($res));
        $this->assertEquals($valueSimple, $res[$attrSimple]);
        $this->assertEquals($valueComplex, $res[$attrComplex]);
    }

    public function test_aroundConvertValue_notDataObject()
    {
        /** === Test Data === */
        $data = [];
        $type = '\Some\Type';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        /* input parameters should be transited into the wrapped method if $TYPE is not a DataObject */
        $mProceed = function ($dataIn, $typeIn) use ($data, $type) {
            $this->assertEquals($data, $dataIn);
            $this->assertEquals($type, $typeIn);
            return true;
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $data,
            $type
        );
        $this->assertTrue($res);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\ServiceOutputProcessor::class, $this->obj);
    }
}