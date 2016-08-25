<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class TypeTool_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mTypeProcessor;
    /** @var  \Praxigento\Core\Reflection\Tool\Type */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mTypeProcessor = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        /** create object to test */
        $this->obj = new \Praxigento\Core\Reflection\Tool\Type(
            $this->mTypeProcessor
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Reflection\Tool\Type::class, $this->obj);
    }

    public function test_formatPropertyName()
    {
        /** === Test Data === */
        $PROPERTY_JSON = 'camel_case_prop';
        $PROPERTY_VALID = 'camelCaseProp';
        /** === Call and asserts  === */
        $res = $this->obj->formatPropertyName($PROPERTY_JSON);
        $this->assertEquals($PROPERTY_VALID, $res);
    }

    public function test_getTypeAsArrayOfTypes()
    {
        /** === Test Data === */
        $TYPE = 'SomeType';
        $TYPE_ARR = 'SomeType[]';
        /** === Call and asserts  === */
        $res = $this->obj->getTypeAsArrayOfTypes($TYPE);
        $this->assertEquals($TYPE_ARR, $res);
    }

    public function test_isArray()
    {
        /** === Test Data === */
        $TYPE = '\Some\Array\Type[]';
        /** === Call and asserts  === */
        $res = $this->obj->isArray($TYPE);
        $this->assertTrue($res);
    }

    public function test_isSimple()
    {
        /** === Test Data === */
        $TYPE = 'type';
        /** === Setup Mocks === */
        // $result = $this->_typeProcessor->isTypeSimple($type);
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->andReturn(true);
        /** === Call and asserts  === */
        $res = $this->obj->isSimple($TYPE);
        $this->assertTrue($res);
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
}