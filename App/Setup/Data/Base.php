<?php
/**
 * Base class to create installers for initial database data in M2 modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Setup\Data;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


abstract class Base
    implements InstallDataInterface
{
    /** @var \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var  \Magento\Framework\Setup\ModuleContextInterface */
    protected $_context;
    /** @var \Praxigento\Core\Api\App\Repo\Generic */
    protected $_repoGeneric;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resource;

    /**
     * Base constructor.
     * @param ModuleDataSetupInterface $_setup
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Api\App\Repo\Generic $daoGeneric
    ) {
        $this->_resource = $resource;
        $this->_conn = $resource->getConnection();
        $this->_repoGeneric = $daoGeneric;
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