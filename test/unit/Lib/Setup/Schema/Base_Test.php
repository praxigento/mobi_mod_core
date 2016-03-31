<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup\Schema;

use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Setup\Db\Dem as Dem;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test__readDemPackage() {
        /** === Test Data === */

        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mDemDb = $this->_mockFor('Praxigento\Core\Lib\Setup\Db');

        $mObj = $this
            ->getMockBuilder('Praxigento\Core\Lib\Setup\Schema\Base')
            ->setConstructorArgs([ $mLogger, $mDemDb ])
            ->getMock();

        // $this->_logger->error("Cannot find DEM node '$pathToDemNode' in file '$pathToFile'.");
        $mLogger
            ->expects($this->once())
            ->method('error');

        /** === Test itself === */
        /** @var  $method \ReflectionMethod */
        $method = new \ReflectionMethod('Praxigento\Core\Lib\Setup\Schema\Base', '_readDemPackage');
        $method->setAccessible(true);
        $method->invokeArgs($mObj, [ __FILE__, 'path to JSON node' ]);
    }

}