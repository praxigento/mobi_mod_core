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

    /** @var  ModuleDataSetupInterface */
    private $_setup;

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected function _getConn()
    {
        return $this->_setup->getConnection();
    }

    protected function _getTableName($entityName)
    {
        $result = $this->_setup->getConnection()->getTableName($entityName);
        return $result;
    }

    /**
     * Module specific routines to create initial module's data on install.
     */
    protected abstract function _setup(ModuleDataSetupInterface $setup, ModuleContextInterface $context);

    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->_setup = $setup;
        /** start M2 setup*/
        $setup->startSetup();
        /* perform module specific operations */
        $this->_setup($setup, $context);
        /** complete M2 setup*/
        $setup->endSetup();
    }
}