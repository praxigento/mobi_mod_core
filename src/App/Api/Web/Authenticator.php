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
 *
 * @deprecated  see implementations of the \Praxigento\Core\App\Api\Web\IAuthenticator interface.
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
    /** @var \Magento\Framework\Session\SaveHandler */
    private $sessSaveHandler;

    public function __construct(
        \Magento\Framework\Session\SaveHandler $sessSaveHandler,
        \Magento\Backend\Model\Auth\Session $sessAdmin,
        \Magento\Customer\Model\Session $sessCustomer,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->sessSaveHandler = $sessSaveHandler;
        $this->sessAdmin = $sessAdmin;
        $this->sessCustomer = $sessCustomer;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentAdminId(ARequest $request = null)
    {
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

//                $sessId = $request->getIsAdmin();
//                $this->sessSaveHandler->open($sessId);
//                $bu = $this->sessSaveHandler->read($sessId);

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
        /* throw exception if request is sent as admin but admin is not logged in */
        $isAdminRequest = $request->getIsAdmin();
        if ($isAdminRequest && !$this->cacheAdminId) {
            $prase = new \Magento\Framework\Phrase('Admin user is not logged in.');
            throw new \Magento\Framework\Exception\AuthorizationException($prase);
        }

        return $this->cacheAdminId;
    }

    public function getCurrentUserId(ARequest $request = null)
    {
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