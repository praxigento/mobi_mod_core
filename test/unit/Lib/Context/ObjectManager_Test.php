<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context;
include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class ObjectManager_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_constructor() {
        $ob = new ObjectManager();
        $this->assertTrue($ob instanceof \Praxigento\Core\Lib\Context\IObjectManager);
    }

    public function test_create() {
        $obm = new ObjectManager();
        $ob1 = $obm->create('Praxigento\Core\Lib\Context\ObjectManager');
        $ob2 = $obm->create('Praxigento\Core\Lib\Context\ObjectManager');
        $this->assertNotEquals(spl_object_hash($ob1), spl_object_hash($ob2));
    }

    public function test_get() {
        $obm = new ObjectManager();
        $ob1 = $obm->get('Praxigento\Core\Lib\Context\ObjectManager');
        $ob2 = $obm->get('Praxigento\Core\Lib\Context\ObjectManager');
        $this->assertEquals(spl_object_hash($ob1), spl_object_hash($ob2));
    }
}