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

abstract class Base implements InstallSchemaInterface {
    /**
     * Name of the core module class to create module's schema.
     *
     * @var string
     */
    protected $_classSchema;

    /**
     * @param $classModuleSchema string name of the class of the module's schema installer
     * (Praxigento\Pv\Lib\Setup\Schema).
     */
    public function __construct($classModuleSchema) {
        $this->_classSchema = $classModuleSchema;
    }

    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** start M2 setup*/
        $setup->startSetup();
        /** Get module's schema installer using DI Object Manager. */
        $obm = Context::instance()->getObjectManager();
        $moduleSchema = $obm->get($this->_classSchema);
        $moduleSchema->setup();
        /** complete M2 setup*/
        $setup->endSetup();
    }
}