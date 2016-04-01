<?php
/**
 * Base for integration tests.
 * Contains Customers Downline Tree and other common usage data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Test;

use Magento\Framework\App\ObjectManager;
use Praxigento\Core\Config as Cfg;
use Praxigento\Core\Lib\Context;
use Praxigento\Downline\Lib\Entity\Customer;
use Praxigento\Downline\Lib\Service\Customer\Request\Add as CustomerAddRequest;
use Praxigento\Downline\Lib\Service\Snap\Request\Calc as DownlineSnapCalcRequest;

abstract class BaseIntegrationTest extends BaseTestCase
{
    const DATE_PERIOD_BEGIN = '20151201';
    const DEFAULT_DOWNLINE_COUNTRY_CODE = 'LV';
    /** Default stock ID for empty Magento instance. */
    const DEF_STOCK_ID = Cfg::DEF_STOCK_ID;
    /** Default 'admin' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_ADMIN = Cfg::DEF_WEBSITE_ID_ADMIN;
    /** Default 'base' website ID for empty Magento instance */
    const DEF_WEBSITE_ID_BASE = Cfg::DEF_WEBSITE_ID_BASE;
    /** @var \Praxigento\Downline\Lib\Service\ICustomer */
    protected $_callDownlineCustomer;
    /** @var \Praxigento\Downline\Lib\Service\ISnap */
    protected $_callDownlineSnap;
    /** @var  \Praxigento\Core\Lib\Context\Dba\IConnection */
    protected $_conn;
    /** @var  \Psr\Log\LoggerInterface */
    protected $_logger;
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
    /** @var  \Praxigento\Core\Lib\Context\IObjectManager */
    protected $_manObj;
    /** @var \Mage_Core_Model_Resource|\Magento\Framework\App\ResourceConnection */
    protected $_resource;
    /** @var  \Praxigento\Core\Lib\IToolbox */
    protected $_toolbox;
    /**
     * Downline tree default dependencies.
     * @var array
     */
    private $DEFAULT_DWNL_TREE = [
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

    public function __construct()
    {
        $this->_manObj = ObjectManager::getInstance();
        $this->_logger = $this->_manObj->get(\Psr\Log\LoggerInterface::class);
        $this->_resource = $this->_manObj->get(\Magento\Framework\App\ResourceConnection::class);
        $this->_conn = $this->_resource->getConnection();
        /* toolbox */
        /* TODO: remove it */
        $this->_toolbox = $this->_manObj->get(\Praxigento\Core\Lib\IToolbox::class);
        /* base services */
        $this->_callDownlineCustomer = $this->_manObj->get(\Praxigento\Downline\Lib\Service\ICustomer::class);
        $this->_callDownlineSnap = $this->_manObj->get(\Praxigento\Downline\Lib\Service\ISnap::class);
    }

    /**
     * @param string $dateBegin datestamp (YYYYMMDD) for the date when the first customer should be created.
     * @param bool $swithDateOnNewCustomer 'true' - create customers day by day, 'false' - create all customers
     * in one day.
     */
    protected function _createDownlineCustomers($dateBegin = self::DATE_PERIOD_BEGIN, $swithDateOnNewCustomer = true)
    {
        /** @var  $period \Praxigento\Core\Lib\Tool\Period */
        $period = $this->_toolbox->getPeriod();
        $dtToday = $dateBegin;
        foreach ($this->DEFAULT_DWNL_TREE as $customerRef => $parentRef) {
            $customerMageId = $this->_mapCustomerMageIdByIndex[$customerRef];
            /* get magento customer data */
            $request = new CustomerAddRequest();
            $request->setCustomerId($customerMageId);
            $request->setParentId($this->_mapCustomerMageIdByIndex[$parentRef]);
            $request->setReference($this->_mapCustomerMageIdByIndex[$customerRef]);
            $request->setCountryCode(self::DEFAULT_DOWNLINE_COUNTRY_CODE);
            $request->setDate($period->getTimestampFrom($dtToday));
            /* Create customer per day or all customers in the same day. */
            if ($swithDateOnNewCustomer) {
                $dtToday = $this->_toolbox->getPeriod()->getPeriodNext($dtToday);
            }
            $response = $this->_callDownlineCustomer->add($request);
            if ($response->isSucceed()) {
                $path = $response->getData(Customer::ATTR_PATH);
                $depth = $response->getData(Customer::ATTR_DEPTH);
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
}