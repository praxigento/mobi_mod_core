<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class ServiceInputProcessor_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mParser;
    /** @var  \Mockery\MockInterface */
    private $mTypeProcessor;
    /** @var  ServiceInputProcessor */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mTypeProcessor = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        $this->mParser = $this->_mock(\Praxigento\Core\Plugin\Framework\Webapi\Sub\Parser::class);
        /** create object to test */
        $this->obj = new ServiceInputProcessor(
            $this->mTypeProcessor,
            $this->mParser
        );
    }

    public function test_aroundConvertValue_isDataObject_isComplex_isArray()
    {
        /** === Test Data === */
        $KEY = 'key';
        $ITEM = 'item';
        $ITEM_TRANSFORMED = 'transformed item';
        $DATA = [
            $KEY => $ITEM
        ];
        $TYPE = \Praxigento\Core\Service\Base\Response::class;
        $RESULT = 'transformation result (DataObject)';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceInputProcessor::class);
        $mProceed = function ($dataIn, $typeIn) {
        };
        // $this->_typeProcessor->isTypeSimple($type) ||
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->andReturn(false);
        // $this->_typeProcessor->isTypeAny($type)
        $this->mTypeProcessor
            ->shouldReceive('isTypeAny')->once()
            ->andReturn(false);
        // $isArrayType = $this->_typeProcessor->isArrayType($type);
        $this->mTypeProcessor
            ->shouldReceive('isArrayType')->once()
            ->andReturn(true);
        // $itemType = $this->_typeProcessor->getArrayItemType($type);
        $this->mTypeProcessor
            ->shouldReceive('getArrayItemType')->once()
            ->andReturn('item type');
        // $result[$key] = $this->_parser->parseArrayData($itemType, $item);
        $this->mParser
            ->shouldReceive('parseArrayData')->once()
            ->andReturn($ITEM_TRANSFORMED);
        // $result = $this->_parser->parseArrayData($type, $data);
        $this->mParser
            ->shouldReceive('parseArrayData')->once()
            ->andReturn($RESULT);
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $DATA,
            $TYPE
        );
        $this->assertEquals($ITEM_TRANSFORMED, $res[$KEY]);
    }

    public function test_aroundConvertValue_isDataObject_isComplex_notArray()
    {
        /** === Test Data === */
        $DATA = [];
        $TYPE = \Praxigento\Core\Service\Base\Response::class;
        $RESULT = 'transformation result (DataObject)';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceInputProcessor::class);
        $mProceed = function ($dataIn, $typeIn) {
        };
        // $this->_typeProcessor->isTypeSimple($type) ||
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->andReturn(false);
        // $this->_typeProcessor->isTypeAny($type)
        $this->mTypeProcessor
            ->shouldReceive('isTypeAny')->once()
            ->andReturn(false);
        // $isArrayType = $this->_typeProcessor->isArrayType($type);
        $this->mTypeProcessor
            ->shouldReceive('isArrayType')->once()
            ->andReturn(false);
        // $result = $this->_parser->parseArrayData($type, $data);
        $this->mParser
            ->shouldReceive('parseArrayData')->once()
            ->andReturn($RESULT);
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $DATA,
            $TYPE
        );
        $this->assertEquals($RESULT, $res);
    }

    public function test_aroundConvertValue_isDataObject_isSimple()
    {
        /** === Test Data === */
        $DATA = [];
        $TYPE = \Praxigento\Core\Service\Base\Response::class;
        $RESULT = 'transformation result (DataObject)';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceInputProcessor::class);
        $mProceed = function ($dataIn, $typeIn) {
        };
        // $this->_typeProcessor->isTypeSimple($type) ||
        $this->mTypeProcessor
            ->shouldReceive('isTypeSimple')->once()
            ->andReturn(true);
        // $result = $this->_typeProcessor->processSimpleAndAnyType($data, $type);
        $this->mTypeProcessor
            ->shouldReceive('processSimpleAndAnyType')->once()
            ->andReturn($RESULT);
        /** === Call and asserts  === */
        $res = $this->obj->aroundConvertValue(
            $mSubject,
            $mProceed,
            $DATA,
            $TYPE
        );
        $this->assertEquals($RESULT, $res);
    }

    public function test_aroundConvertValue_notDataObject()
    {
        /** === Test Data === */
        $DATA = [];
        $TYPE = '\Some\Type';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\Framework\Webapi\ServiceInputProcessor::class);
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
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\ServiceInputProcessor::class, $this->obj);
    }
}