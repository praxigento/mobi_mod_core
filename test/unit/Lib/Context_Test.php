<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib;
include_once(__DIR__ . '/../phpunit_bootstrap.php');

class Context_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_singleton() {
        /* get singleton instance */
        $ctx = Context::instance();
        $this->assertTrue($ctx instanceof \Praxigento\Core\Lib\Context);
    }

    public function test_reset() {
        /* get singleton instance */
        $ctx = Context::instance();
        $hashBefore = spl_object_hash($ctx);
        /* reset context */
        $ctx->reset();
        /* get mock as singleton instance */
        $afterReset = Context::instance();
        $hashAfter = spl_object_hash($afterReset);
        $this->assertTrue($afterReset instanceof \Praxigento\Core\Lib\Context);
        $this->assertNotEquals($hashBefore, $hashAfter);
    }

    public function test_getMappedClassName_mage1() {
        /* Create context mock */
        $mCtx = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context')
            ->setMethods([ 'isMage2' ])
            ->getMock();
        // self::instance()->isMage2()
        $mCtx
            ->expects($this->once())
            ->method('isMage2')
            ->willReturn(false);
        Context::set($mCtx);
        /* get mock as singleton instance */
        $ctx = Context::instance();
        $clazz = $ctx->getMappedClassName('Magento\Framework\DB\Adapter\Pdo\Mysql');
//        $this->assertEquals('Magento_Db_Adapter_Pdo_Mysql', $clazz);
    }

    public function test_getMappedClassName_mage2() {
        /* Create context mock */
        $mCtx = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context')
            ->setMethods([ 'isMage2' ])
            ->getMock();
        // self::instance()->isMage2()
        $mCtx
            ->expects($this->once())
            ->method('isMage2')
            ->willReturn(true);
        Context::set($mCtx);
        /* get mock as singleton instance */
        $ctx = Context::instance();
        $clazz = $ctx->getMappedClassName('Magento\Framework\DB\Adapter\Pdo\Mysql');
        $this->assertEquals('Magento\Framework\DB\Adapter\Pdo\Mysql', $clazz);
    }

    public function test_getMappedEntityName_mage1() {
        /* Create context mock */
        $mCtx = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context')
            ->setMethods([ 'isMage2' ])
            ->getMock();
        // self::instance()->isMage2()
        $mCtx
            ->expects($this->once())
            ->method('isMage2')
            ->willReturn(false);
        Context::set($mCtx);
        /* get mock as singleton instance */
        $ctx = Context::instance();
        $name = $ctx->getMappedEntityName('sales_order');
//        $this->assertEquals('sales_flat_order', $name);
    }

    public function test_getMappedEntityName_mage2() {
        /* Create context mock */
        $mCtx = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context')
            ->setMethods([ 'isMage2' ])
            ->getMock();
        // self::instance()->isMage2()
        $mCtx
            ->expects($this->once())
            ->method('isMage2')
            ->willReturn(true);
        Context::set($mCtx);
        /* get mock as singleton instance */
        $ctx = Context::instance();
        $name = $ctx->getMappedEntityName('sales_order');
        $this->assertEquals('sales_order', $name);
    }

    /**
     * Reset context after each test (clean up context mocks).
     */
    protected function tearDown() {
        Context::reset();
    }

}