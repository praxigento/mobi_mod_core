<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web;

use Magento\Backend\Model\Session\AdminConfig as AnAdminConfig;
use Praxigento\Core\App\Api\Web\Request as ARequest;
use Praxigento\Core\App\Api\Web\Request\Dev as ADev;

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
    /** @var \Magento\Customer\Model\Session */
    private $sessCustomer;

    public function __construct(
        \Magento\Customer\Model\Session $sessCustomer,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->sessCustomer = $sessCustomer;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentAdminId(ARequest $request = null) {
        if (is_null($this->cacheAdminId)) {
            $this->cacheAdminId = false; // to prevent execution reiteration for not logged in admins
            $offeredId = null;
            if ($request) {
                $offeredId = $request->get('/' . ARequest::DEV . '/' . ADev::ADMIN_ID);
            }
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offeredId)
            ) {
                /* use offered user ID if MOBI API DevMode is enabled */
                $this->cacheAdminId = (int)$offeredId;
            } else {
                /* get currently logged in admin data */
                if (
                    (isset($_SESSION[AnAdminConfig::SESSION_NAME_ADMIN])) &&
                    (isset($_SESSION[AnAdminConfig::SESSION_NAME_ADMIN]['user']))
                ) {
                    $user = $_SESSION[AnAdminConfig::SESSION_NAME_ADMIN]['user'];
                    if ($user instanceof \Magento\User\Model\User) {
                        $this->cacheAdminId = $user->getId();
                    }
                }
            }
        }
        return $this->cacheAdminId;
    }

    public function getCurrentCustomerId(ARequest $request = null) {
        if (is_null($this->cacheCustomerId)) {
            $offeredId = null;
            if ($request) {
                $offeredId = $request->get('/' . ARequest::DEV . '/' . ADev::CUST_ID);
            }
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