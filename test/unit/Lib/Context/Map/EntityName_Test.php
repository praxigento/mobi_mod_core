<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Map;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class EntityName_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    /**
     * This is for code coverage only.
     */
    public function test_getM1Name() {
        EntityName::getM1Name('sales_order');
    }

}