<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../phpunit_bootstrap.php');

class Box_IntegrationTest extends \Praxigento\Core\Lib\Test\BaseTestCase {
    public function test_gets() {
        /** @var  $toolbox \Praxigento\Core\Lib\IToolbox */
        $toolbox = Context::instance()->getObjectManager()->get('Praxigento\Core\Lib\Tool\Box');
        $this->assertTrue($toolbox->getConvert() instanceof Convert);
        $this->assertTrue($toolbox->getDate() instanceof Date);
        $this->assertTrue($toolbox->getFormat() instanceof Format);
        $this->assertTrue($toolbox->getPeriod() instanceof Period);
    }
}