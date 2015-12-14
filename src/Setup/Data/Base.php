<?php
/**
 * Base class to create installers for initial database data in M2 modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Data;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Setup\IData;

abstract class Base implements InstallDataInterface {
    /**
     * Name of the core module class to create module's data.
     *
     * @var string
     */
    protected $_classData;

    /**
     * @param $classModuleData string name of the class of the module's data installer
     * (Praxigento\Pv\Lib\Setup\Data).
     */
    public function __construct($classModuleData) {
        $this->_classData = $classModuleData;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        /** start M2 setup*/
        $setup->startSetup();
        /** Get module's schema installer using DI Object Manager. */
        $obm = Context::instance()->getObjectManager();
        /** @var  $moduleData IData */
        $moduleData = $obm->get($this->_classData);
        $moduleData->install();
        /** complete M2 setup*/
        $setup->endSetup();
    }
}