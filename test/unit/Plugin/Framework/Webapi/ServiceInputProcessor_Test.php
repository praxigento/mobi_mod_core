<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Plugin\Framework\Webapi;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class ServiceInputProcessor_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mTypeProcessor;
    /** @var  \Mockery\MockInterface */
    private $mTypePropsRegistry;
    /** @var  \Mockery\MockInterface */
    private $mManObj;
    /** @var  ServiceInputProcessor */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mManObj = $this->_mockObjectManager();
        $this->mTypeProcessor = $this->_mock(\Magento\Framework\Reflection\TypeProcessor::class);
        $this->mTypePropsRegistry = $this->_mock(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry::class);
        /** create object to test */
        $this->obj = new ServiceInputProcessor(
            $this->mManObj,
            $this->mTypeProcessor,
            $this->mTypePropsRegistry
        );
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Plugin\Framework\Webapi\ServiceInputProcessor::class, $this->obj);
    }

}