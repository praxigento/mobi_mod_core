<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\WebApi;

use Praxigento\Core\Config as Cfg;

/**
 * Default implementation for REST API authenticator.
 */
class Authenticator
    implements \Praxigento\Core\App\WebApi\IAuthenticator
{
    /** @var  \Praxigento\Core\Data */
    protected $cacheCurrentCustomer;
    /** @var \Praxigento\Core\Helper\Config */
    protected $hlpCfg;
    /** @var \Magento\Customer\Model\Session */
    protected $sessCustomer;

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
                $this->cacheCurrentCustomer = new \Praxigento\Core\Data($data);
            } else {
                $this->cacheCurrentCustomer = new \Praxigento\Core\Data();
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

    public function isEnabledDevMode()
    {
        $result = $this->hlpCfg->getApiAuthenticationEnabledDevMode();
        return $result;
    }
}