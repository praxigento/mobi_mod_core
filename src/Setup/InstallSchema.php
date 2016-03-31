<?php
/**
 * Create DB schema for the module.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Praxigento\Core\Setup\Schema\Base as SchemaBase;

class InstallSchema extends SchemaBase
{
    protected function _setup(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // nothing to do in this module
    }


}