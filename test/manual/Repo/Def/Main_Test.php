<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo\Def;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Main_ManualTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_construct() {
        $obm = Context::instance()->getObjectManager();
        /** @var  $repo \Praxigento\Core\Lib\Repo\IBasic */
        $repo = $obm->get('\Praxigento\Core\Lib\Repo\ICore');
        $this->assertTrue($repo instanceof \Praxigento\Core\Lib\Repo\Def\Main);
    }
}