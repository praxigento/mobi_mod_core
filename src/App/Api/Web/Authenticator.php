<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web;

/**
 * Default implementation for REST API authenticator.
 */
class Authenticator
    implements \Praxigento\Core\App\Api\Web\IAuthenticator
{
    /** @var int */
    private $cacheAdminId;
    /** @var int */
    private $cacheCustomerId;
    /** @var \Praxigento\Core\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Backend\Model\Auth\Session */
    private $sessAdmin;
    /** @var \Magento\Customer\Model\Session */
    private $sessCustomer;

    public function __construct(
        \Magento\Backend\Model\Auth\Session $sessAdmin,
        \Magento\Customer\Model\Session $sessCustomer,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->sessAdmin = $sessAdmin;
        $this->sessCustomer = $sessCustomer;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentAdminId($offeredId = null) {
        if (is_null($this->cacheAdminId)) {
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offeredId)
            ) {
                /* use offered user ID if MOBI API DevMode is enabled */
                $this->cacheCustomerId = (int)$offeredId;
            } else {
                /* get currently logged in admin data */
                $user = $this->sessAdmin->getUser();
                if ($user) {
                    $this->cacheAdminId = $user->getId();
                }
            }
        }
        return $this->cacheAdminId;
    }

    public function getCurrentCustomerId($offeredId = null) {
        if (is_null($this->cacheCustomerId)) {
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offeredId)
            ) {
                /* use offered Customer ID if MOBI API DevMode is enabled */
                $this->cacheCustomerId = (int)$offeredId;
            } else {
                /* get currently logged in customer data */
                $customer = $this->sessCustomer->getCustomer();
                if ($customer) {
                    $this->cacheCustomerId = $customer->getId();
                }
            }
        }
        return $this->cacheCustomerId;
    }
}