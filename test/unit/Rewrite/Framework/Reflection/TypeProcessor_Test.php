<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Rewrite\Framework\Reflection;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class TypeProcessorToTest extends TypeProcessor
{
    /**
     * Wrapper for protected method to test it.
     *
     * @param \Zend\Code\Reflection\MethodReflection $methodReflection
     * @param $typeName
     */
    public function processMethod(
        \Zend\Code\Reflection\MethodReflection $methodReflection,
        $typeName
    ) {
        return parent::_processMethod($methodReflection, $typeName);
    }
}

class TypeProcessor_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  TypeProcessorToTest */
    private $obj;
    /** @var  \Magento\Framework\Reflection\TypeProcessor */
    private $mSubject;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mSubject = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        /** create object to test */
        $this->obj = new TypeProcessorToTest();
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(TypeProcessor::class, $this->obj);
    }

    public function test_processMethod()
    {
        /** === Test Data === */
        $TYPE_NAME = 'type_name';
        $NAME = 'notAccessorMethod';
        /** === Setup Mocks === */
        $mMethodReflection = $this->_mock(\Zend\Code\Reflection\MethodReflection::class);
        // $name = $methodReflection->getName();
        $mMethodReflection
            ->shouldReceive('getName')->once()
            ->andReturn($NAME);
        /** === Call and asserts  === */
        $this->obj->processMethod(
            $mMethodReflection,
            $TYPE_NAME
        );
    }

}