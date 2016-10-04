<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Reflection;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class TypeProcessor_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mSubject;
    /** @var  TypeProcessor */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mSubject = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        /** create object to test */
        $this->obj = new TypeProcessor();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_TranslateTypeName_isNotPraxigentoNamespace()
    {
        /** === Test Data === */
        $class = '\Vendor\Core\Data\Object\Some\Element';
        /** === Setup Mocks === */
        $mProceed = function () {
            throw new \InvalidArgumentException();
        };
        /** === Call and asserts  === */
        $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $class
        );
    }

    public function test_TranslateTypeName_isPraxigentoNamespace()
    {
        /** === Test Data === */
        $class = '\Praxigento\Core\Data\Object\Some\Element';
        $result = 'PraxigentoCoreDataObjectSomeElement';
        /** === Setup Mocks === */
        $mProceed = function () {
            throw new \InvalidArgumentException();
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $class
        );
        $this->assertEquals($result, $res);
    }

    public function test_TranslateTypeName_proceed()
    {
        /** === Test Data === */
        $class = 'classname to translate';
        $result = 'transaltion result';
        /** === Setup Mocks === */
        $mProceed = function ($classIn) use ($class, $result) {
            $this->assertEquals($class, $classIn);
            return $result;
        };
        /** === Call and asserts  === */
        $res = $this->obj->aroundTranslateTypeName(
            $this->mSubject,
            $mProceed,
            $class
        );
        $this->assertEquals($result, $res);
    }
}