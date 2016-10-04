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
class MethodsMap_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mMapMethods;
    /** @var  \Mockery\MockInterface */
    private $mSubject;
    /** @var  MethodsMap */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mMapMethods = $this->_mock(\Praxigento\Core\Reflection\Map\Methods::class);
        $this->mSubject = $this->_mock(\Magento\Framework\Reflection\MethodsMap::class);
        /** create object to test */
        $this->obj = new MethodsMap(
            $this->mMapMethods
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(MethodsMap::class, $this->obj);
    }

    public function test_aroundGetMethodsMap()
    {
        /** === Test Data === */
        $interfaceName = 'interface name';
        /** === Setup Mocks === */
        $mProceed = function () {
        };
        // $result = $this->_mapMethods->getMap($interfaceName);
        $mResult = 'result';
        $this->mMapMethods
            ->shouldReceive('getMap')->once()
            ->with($interfaceName)
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $res = $this->obj->aroundGetMethodsMap(
            $this->mSubject,
            $mProceed,
            $interfaceName
        );
        $this->assertEquals($mResult, $res);
    }
}