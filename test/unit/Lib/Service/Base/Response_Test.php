<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Base;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Response_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_constructor() {
        /** @var  $obj \Praxigento\Core\Lib\Service\Base\Response */
        $obj = new \Praxigento\Core\Lib\Service\Base\Response();
        $obj->setErrorCode('code');
        $obj->setErrorMessage('message');
        $this->assertEquals('code', $obj->getErrorCode());
        $this->assertEquals('message', $obj->getErrorMessage());
        $this->assertFalse($obj->isSucceed());
    }

}