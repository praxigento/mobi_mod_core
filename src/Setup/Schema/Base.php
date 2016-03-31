<?php
/**
 * Base class to create database schema installers.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Schema;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Praxigento\Core\Lib\Context;

abstract class Base implements InstallSchemaInterface
{
    /** @var \Praxigento\Core\Setup\Dem\Tool */
    protected $_toolDem;
    /**
     * Utility to parse DEM JSON and to create DB structure.
     *
     * @var  \Praxigento\Core\Lib\Setup\Db
     */
    protected $_demDb;

    public function __construct(
        \Praxigento\Core\Setup\Dem\Tool $toolDem
    ) {
        $this->_toolDem = $toolDem;
    }

    /**
     * Module specific routines to create database structure on install.
     */
    protected abstract function _setup(SchemaSetupInterface $setup, ModuleContextInterface $context);

    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /* start M2 setup*/
        $setup->startSetup();
        /* perform module specific operations */
        $this->_setup($setup, $context);
        /* complete M2 setup*/
        $setup->endSetup();
    }
}