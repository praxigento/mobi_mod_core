<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigneto\Core\Setup;


use Praxigneto\Core\Setup\InstallSchema;

include_once(__DIR__ . '/../phpunit_bootstrap.php');

class InstallSchema_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_constructor() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        /** @var  $obj InstallSchema */
        $obj = new InstallSchema();
    }

}