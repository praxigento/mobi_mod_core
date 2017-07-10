<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Business\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Format_Test
    extends \Praxigento\Core\Test\BaseCase\Manual
{


    public function test_do()
    {
        $obm = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var  $obj \Praxigento\Core\Tool\Def\Format */
        $obj = $obm->get(\Praxigento\Core\Tool\Def\Format::class);

        $obj = [];
        $obj['val'] = 6.40;

        $json = json_encode($obj);

        $res = $obj->toNumber(6.40);
    }
}