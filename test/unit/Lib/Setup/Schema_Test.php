<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;


include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Schema_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_install() {
        /** === Test Data === */
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mSetupDb = $this->_mockDemSetupDb();
        /**
         * Prepare request and perform call.
         */
        $obj = new Schema($mLogger, $mSetupDb);
        $obj->setup();
    }
}