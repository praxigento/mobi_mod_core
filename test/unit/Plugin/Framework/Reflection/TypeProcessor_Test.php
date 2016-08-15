<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Reflection;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class TypeProcessor_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  TypeProcessor */
    private $obj;
    /** @var  \Magento\Framework\Reflection\TypeProcessor */
    private $mSubject;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mSubject = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        /** create object to test */
        $this->obj = new TypeProcessor();
    }

    public function test_TranslateTypeName_proceed()
    {
        /** === Test Data === */
        $CLASS = 'classname to translate';
        $RESULT = 'transaltion result';
        /** === Setup Mocks === */
        $mProceed = function ($classIn) use ($CLASS, $RESULT) {
            $this->assertEquals($CLASS, $classIn);
            return $RESULT;
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $CLASS
        );
        $this->assertEquals($RESULT, $res);
    }

    public function test_TranslateTypeName_isPraxigentoNamespace()
    {
        /** === Test Data === */
        $CLASS = '\Praxigento\Core\Data\Object\Some\Element';
        $RESULT = 'PraxigentoCoreDataObjectSomeElement';
        /** === Setup Mocks === */
        $mProceed = function ($classIn) {
            throw new \InvalidArgumentException();
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $CLASS
        );
        $this->assertEquals($RESULT, $res);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_TranslateTypeName_isNotPraxigentoNamespace()
    {
        /** === Test Data === */
        $CLASS = '\Vendor\Core\Data\Object\Some\Element';
        /** === Setup Mocks === */
        $mProceed = function ($classIn) {
            throw new \InvalidArgumentException();
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $CLASS
        );
    }
}