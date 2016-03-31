<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class DbAdapter_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_construct_m1() {
        /** === Test Data === */
        /** === Mocks === */
        $mResource = $this->_mockResource();
        /** === Test itself === */
        $obj = new DbAdapter($mResource, null);
        $this->assertNotNull($obj);
    }

    public function test_construct_m2() {
        if(!defined("IS_M1_TESTS")) {
            /** === Test Data === */
            /** === Mocks === */
            $mResource = $this->_mockResource();
            /** === Test itself === */
            $obj = new DbAdapter($mResource);
            $this->assertNotNull($obj);
        }
    }

    public function test_getters() {
        /** === Test Data === */
        /** === Mocks === */
        $mResource = $this->_mockResource();
        $mConnection = $this->_mockFor('Magento\Framework\DB\Adapter\Pdo\Mysql');

        $mResource
            ->expects($this->once())
            ->method('getConnection')
            ->willReturn($mConnection);
        /** === Test itself === */
        $obj = new DbAdapter($mResource);
        $this->assertNotNull($obj->getResource());
        $this->assertNotNull($obj->getDefaultConnection());
    }

    public function test_getTableName() {
        /** === Test Data === */
        $TABLE = 'table_name';
        $MAPPED = 'mapped_name';
        /** === Mocks === */
        $mResource = $this->_mockResource();
        $mResource
            ->expects($this->once())
            ->method('getTableName')
            ->with($TABLE)
            ->willReturn($MAPPED);
        /** === Test itself === */
        $obj = new DbAdapter($mResource);
        $res = $obj->getTableName($TABLE);
        $this->assertEquals($MAPPED, $res);

    }

}