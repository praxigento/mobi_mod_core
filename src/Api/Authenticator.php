<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api;

use \Praxigento\Core\Config as Cfg;

/**
 * Default implementation for REST API authenticator.
 */
class Authenticator
    implements \Praxigento\Core\Api\IAuthenticator
{
    /** @var \Praxigento\Core\Helper\Config */
    protected $hlpCfg;
    /** @var \Magento\Customer\Model\Session */
    protected $sessCustomer;
    /** @var  \Flancer32\Lib\Data */
    protected $cacheCurrentCustomer;

    public function __construct(
        \Magento\Customer\Model\Session $sessCustomer,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->sessCustomer = $sessCustomer;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentCustomerData($offer = null)
    {
        if (is_null($this->cacheCurrentCustomer)) {
            /* use offered Customer ID if MOBI API DevMode is enabled */
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offer)
            ) {
                $this->sessCustomer->setCustomerId($offer);
            }
            /* load customer data */
            $customer = $this->sessCustomer->getCustomer();
            if ($customer) {
                $data = $customer->getData();
                $this->cacheCurrentCustomer = new \Flancer32\Lib\Data($data);
            } else {
                $this->cacheCurrentCustomer = new \Flancer32\Lib\Data();
            }
        }
        return $this->cacheCurrentCustomer;
    }

    public function getCurrentCustomerId($offer = null)
    {
        $data = $this->getCurrentCustomerData($offer);
        $result = $data->get(Cfg::E_CUSTOMER_A_ENTITY_ID);
        return $result;
    }

    public function isAuthenticated()
    {
        $result = $this->sessCustomer->isLoggedIn();
        return $result;
    }
}