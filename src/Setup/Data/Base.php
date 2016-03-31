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

abstract class Base implements InstallDataInterface
{

    /**
     * Module specific routines to create initial module's data on install.
     */
    protected abstract function _setup(ModuleDataSetupInterface $setup, ModuleContextInterface $context);

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** start M2 setup*/
        $setup->startSetup();
        /* perform module specific operations */
        $this->_setup($setup, $context);
        /** complete M2 setup*/
        $setup->endSetup();
    }
}