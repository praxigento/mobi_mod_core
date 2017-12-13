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
use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Tool\IPeriod;
use Praxigento\Downline\Repo\Entity\Data\Customer;
use Praxigento\Downline\Service\Customer\Request\Add as CustomerAddRequest;
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
    /** @var  IPeriod */
    protected $_toolPeriod;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_manObj = ObjectManager::getInstance();
        $this->_logger = $this->_manObj->get(\Psr\Log\LoggerInterface::class);
        $this->_resource = $this->_manObj->get(\Magento\Framework\App\ResourceConnection::class);
        $this->_conn = $this->_resource->getConnection();
        $this->_toolPeriod = $this->_manObj->get(IPeriod::class);
        /* base services */
        $this->_callDownlineCustomer = $this->_manObj->get(\Praxigento\Downline\Service\ICustomer::class);
        $this->_callDownlineSnap = $this->_manObj->get(\Praxigento\Downline\Service\ISnap::class);
        /* set up application */
        $this->_setAreaCode();
    }

    /**
     * Reset cache for classes that use internal cache.
     */
    protected function _cacheReset()
    {
        /** @var  $obj \Praxigento\Core\App\ICached */
        // old services
        $obj = $this->_manObj->get(\Praxigento\Pv\Service\ISale::class);
        $obj->cacheReset();
        $obj = $this->_manObj->get(\Praxigento\Pv\Service\ITransfer::class);
        $obj->cacheReset();
        // fresh classes
        $this->_manObj->get(\Praxigento\Core\Tool\Def\Period::class)->cacheReset();
        $this->_manObj->get(\Praxigento\Odoo\Repo\Odoo\Connector\Api\Def\Login::class)->cacheReset();
    }

    /**
     * @param string $dateBegin datestamp (YYYYMMDD) for the date when the first customer should be created.
     * @param bool $switchDateOnNewCustomer 'true' - create customers day by day, 'false' - create all customers
     * in one day.
     */
    protected function _createDownlineCustomers($dateBegin = self::DATE_PERIOD_BEGIN, $switchDateOnNewCustomer = true)
    {
        $dtToday = $dateBegin;
        foreach ($this->DEFAULT_DWNL_TREE as $customerRef => $parentRef) {
            $customerMageId = $this->_mapCustomerMageIdByIndex[$customerRef];
            /* get magento customer data */
            $request = new CustomerAddRequest();
            $request->setCustomerId($customerMageId);
            $request->setParentId($this->_mapCustomerMageIdByIndex[$parentRef]);
            $request->setReference($this->_mapCustomerMageIdByIndex[$customerRef]);
            $request->setCountryCode(self::DEFAULT_DOWNLINE_COUNTRY_CODE);
            $request->setDate($this->_toolPeriod->getTimestampFrom($dtToday));
            /* Create customer per day or all customers in the same day. */
            if ($switchDateOnNewCustomer) {
                $dtToday = $this->_toolPeriod->getPeriodNext($dtToday);
            }
            $response = $this->_callDownlineCustomer->add($request);
            if ($response->isSucceed()) {
                $path = $response->get(Customer::ATTR_PATH);
                $depth = $response->get(Customer::ATTR_DEPTH);
                $this->_logger->debug("New customer #$customerMageId is added to path '$path' on depth $depth at '$dtToday'.");
            } else {
                $this->_logger->error("Cannot add new customer #$customerMageId to downline tree.");
            }
        }
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
        $this->_cacheReset();
    }
}