<?php
/**
 * Base class to create database schema installers.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Setup\Schema;

abstract class Base
    implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /** @var \Praxigento\Core\App\Setup\Dem\Tool */
    protected $toolDem;

    public function __construct(
        \Praxigento\Core\App\Setup\Dem\Tool $toolDem

    ) {
        $this->toolDem = $toolDem;
    }

    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $setup->startSetup();
        /* perform module specific operations */
        $this->setup();
        $setup->endSetup();
    }

    /**
     * Module specific routines to create database structure on install.
     */
    protected abstract function setup();
}