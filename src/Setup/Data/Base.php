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
    /** @var \Praxigento\Core\Repo\IBasic */
    protected $_repoBasic;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resource;
    /** @var \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var  \Magento\Framework\Setup\ModuleContextInterface */
    protected $_context;

    /**
     * Base constructor.
     * @param ModuleDataSetupInterface $_setup
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Repo\IBasic $repoBasic
    ) {
        $this->_resource = $resource;
        $this->_conn = $resource->getConnection();
        $this->_repoBasic = $repoBasic;
    }

    /**
     * Module specific routines to create initial module's data on install.
     */
    protected abstract function _setup();

    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->_context = $context;
        $setup->startSetup();
        /* perform module specific operations */
        $this->_setup();
        $setup->endSetup();
    }
}