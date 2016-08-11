<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Parser_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
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
        $this->mToolType = $this->_mock(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypeTool::class);
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

    public function test_parseArrayData_isDataObject_isArray()
    {
        /** === Test Data === */
        $TYPE = '\Praxigento\Core\Service\Base\Response[]';
        $TYPE_NORM = 'Praxigento\Core\Service\Base\Response';
        $TYPE_DATA = [];
        $DATA = [new \Praxigento\Core\Service\Base\Response()];
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
        //
        // SECOND ITERATION
        //
        // $isArray = $this->_toolType->isArray($type);
        $this->mToolType
            ->shouldReceive('isArray')->once()
            ->andReturn(false);
        /** === Call and asserts  === */
        $res = $this->obj->parseArrayData($TYPE, $DATA);
        $this->assertEquals($DATA, $res);
    }

}