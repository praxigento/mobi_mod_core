<?php
/**
 * Base for integration tests.
 * Contains Customers Downline Tree and other common usage data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManagerInterface;
use Praxigento\Core\Api\Helper\Period as HPeriod;
use Praxigento\Core\Config as Cfg;
use Praxigento\Downline\Service\Snap\Request\Calc as DownlineSnapCalcRequest;

abstract class BaseIntegrationTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    const DATE_PERIOD_BEGIN = '20151201';
    const DEFAULT_DOWNLINE_COUNTRY_CODE = 'LV';
    /** Default stock ID for empty Magento instance. */
    const DEF_STOCK_ID = Cfg::DEF_STOCK_ID;
    /** Default 'admin' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_ADMIN = Cfg::DEF_WEBSITE_ID_ADMIN;
    /** Default 'base' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_BASE = Cfg::DEF_WEBSITE_ID_BASE;
    /**
     * Downline tree default dependencies.
     * @var array
     */
    protected $DEFAULT_DWNL_TREE = [
        1 => 1,
        2 => 1,
        3 => 1,
        4 => 2,
        5 => 2,
        6 => 3,
        7 => 3,
        8 => 6,
        9 => 6,
        10 => 7,
        11 => 7,
        12 => 10,
        13 => 10
    ];
    /** @var \Praxigento\Downline\Service\ICustomer */
    protected $_callDownlineCustomer;
    /** @var \Praxigento\Downline\Service\ISnap */
    protected $_callDownlineSnap;
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var  \Psr\Log\LoggerInterface */
    protected $_logger;
    /** @var  ObjectManagerInterface */
    protected $_manObj;
    /**
     * Map index by Magento ID (index started from 1).
     *
     * @var array [ $entityId  => $index, ... ]
     */
    protected $_mapCustomerIndexByMageId = [];
    /**
     * Map Magento ID by index (index started from 1).
     *
     * @var array [ $index  => $entityId, ... ]
     */
    protected $_mapCustomerMageIdByIndex = [];
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resource;
    /** @var  HPeriod */
    protected $hlpPeriod;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_manObj = ObjectManager::getInstance();
        $this->_logger = $this->_manObj->get(\Psr\Log\LoggerInterface::class);
        $this->_resource = $this->_manObj->get(\Magento\Framework\App\ResourceConnection::class);
        $this->_conn = $this->_resource->getConnection();
        $this->hlpPeriod = $this->_manObj->get(HPeriod::class);
        /* base services */
        $this->_callDownlineCustomer = $this->_manObj->get(\Praxigento\Downline\Service\ICustomer::class);
        $this->_callDownlineSnap = $this->_manObj->get(\Praxigento\Downline\Service\ISnap::class);
        /* set up application */
        $this->_setAreaCode();
    }

    protected function _createDownlineSnapshots($dsUpTo)
    {
        $req = new DownlineSnapCalcRequest();
        $req->setDatestampTo($dsUpTo);
        $resp = $this->_callDownlineSnap->calc($req);
        $this->assertTrue($resp->isSucceed());
    }

    /**
     * Create $total Magento customers with emails "customer_$i[at]test.com" and save mapping to MageId into
     * $this->_testMageCustomers & $this->_testMageCustomersReverted
     *
     * ATTENTION: There is warning "Test method "_createMageCustomers" in test class "..." is not public."
     * in case of method's visibility is 'protected' (after $total argument was added).
     *
     * @param int $total total count of the Magento customers to be created.
     */
    protected function _createMageCustomers($total = 13)
    {
        $tbl = $this->_resource->getTableName(Cfg::ENTITY_MAGE_CUSTOMER);
        for ($i = 1; $i <= $total; $i++) {
            $email = "customer_$i@test.com";
            $this->_conn->insert(
                $tbl,
                [Cfg::E_CUSTOMER_A_EMAIL => $email]
            );
            $id = $this->_conn->lastInsertId($tbl);
            $this->_mapCustomerMageIdByIndex[$i] = $id;
            $this->_mapCustomerIndexByMageId[$id] = $i;
            $this->_logger->debug("New Magento customer #$i is added with ID=$id ($email).");
        }
        $this->_logger->debug("Total $total customer were added to Magento.");
    }

    protected function _logMemoryUsage()
    {
        $memPeak = number_format(memory_get_peak_usage(), 0, '.', ',');
        $memCurrent = number_format(memory_get_usage(), 0, '.', ',');
        $this->_logger->debug("Current memory usage: $memCurrent bytes (peak: $memPeak bytes).");
    }

    private function _setAreaCode()
    {
        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->_manObj->get(\Magento\Framework\App\State::class);
        try {
            $appState->getAreaCode();
        } catch (\Exception $e) {
            $areaCode = 'adminhtml';
            $appState->setAreaCode($areaCode);
            /** @var \Magento\Framework\ObjectManager\ConfigLoaderInterface $configLoader */
            $configLoader = $this->_manObj->get(\Magento\Framework\ObjectManager\ConfigLoaderInterface::class);
            $config = $configLoader->load($areaCode);
            $this->_manObj->configure($config);
        }
    }

    protected function setUp()
    {
        parent::setUp();
    }
}