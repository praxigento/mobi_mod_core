<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Test\Setup;

include_once(__DIR__ . '/../phpunit_bootstrap.php');

class Main_IntegrationTest
    extends \Praxigento\Core\Test\BaseCase\Manual
{
    protected function setUp()
    {
        parent::setUp();
        $this->_logger = $this->_manObj->get('loggerSetup'); // use standalone logger for setup logs
    }


    public function test_main()
    {
        $this->_logger->debug('Setup Integration tests is started.');
        $this->_conn->beginTransaction();
        try {
            $tbls = $this->_conn->getTables();
            $this->_logger->info("All tables:\n" . var_export($tbls, true));
        } finally {
            // $this->_conn->commit();
            $this->_conn->rollBack();
        }
        $this->_logger->debug('Setup Integration test is completed, all transactions are rolled back.');
    }
}