<?php
/**
 * Empty class to get stub for tests
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Data;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_install() {
        /** === Test Data === */
        $CLASS_NAME = '\Praxigento\Module\Lib\Setup\Data';
        /** === Mocks === */
        $mockSetup = $this
            ->getMockBuilder('Magento\Framework\Setup\ModuleDataSetupInterface')
            ->getMock();
        $mockMageContext = $this
            ->getMockBuilder('Magento\Framework\Setup\ModuleContextInterface')
            ->getMock();
        // $setup->startSetup();
        $mockSetup
            ->expects($this->once())
            ->method('startSetup');
        // $obm = Context::instance()->getObjectManager();
        $mockCtx = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context')
            ->getMock();
        Context::set($mockCtx);
        $mockObm = $this
            ->getMockBuilder('Praxigento\Core\Lib\Context\IObjectManager')
            ->getMock();
        $mockCtx
            ->expects($this->once())
            ->method('getObjectManager')
            ->willReturn($mockObm);
        // $moduleData = $obm->get($this->_classData);
        $mockModData = $this
            ->getMockBuilder('Praxigento\Core\Lib\Setup\IData')
            ->getMock();
        $mockObm
            ->expects($this->once())
            ->method('get')
            ->with($CLASS_NAME)
            ->willReturn($mockModData);
        // $moduleData->install();
        $mockModData
            ->expects($this->once())
            ->method('install');
        // $setup->endSetup();
        $mockSetup
            ->expects($this->once())
            ->method('endSetup');
        /** Test itself. */
        /** @var  $mockBase \Praxigento\Core\Setup\Data\Base */
        $mockBase = $this->getMockBuilder('Praxigento\Core\Setup\Data\Base')
                         ->setConstructorArgs([ $CLASS_NAME ])
                         ->setMethods(null)
                         ->getMock();
        $mockBase->install($mockSetup, $mockMageContext);

    }

}