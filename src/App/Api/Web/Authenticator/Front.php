<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Api\Web\Authenticator;

use Praxigento\Core\App\Api\Web\Request as ARequest;
use Praxigento\Core\App\Api\Web\Request\Dev as ADev;

/**
 * MOBI Authenticator for frontend (regular customer authentication),
 */
class Front
    implements \Praxigento\Core\App\Api\Web\IAuthenticator
{
    /** @var int|bool|null */
    private $cacheId = false;
    /** @var \Praxigento\Core\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Customer\Model\Session */
    private $session;

    public function __construct(
        \Magento\Customer\Model\Session $sessCustomer,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->session = $sessCustomer;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentUserId(ARequest $request = null)
    {
        /* $cacheId can be equal to 'null' if no customer is anonymous */
        if ($this->cacheId === false) {
            $offeredId = null;
            if ($request) {
                $path = ARequest::PS . ARequest::DEV . ARequest::PS . ADev::CUST_ID;
                $offeredId = $request->get($path);
            }
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offeredId)
            ) {
                /* use offered Customer ID if MOBI API DevMode is enabled */
                $this->cacheId = (int)$offeredId;
            } else {
                /* get currently logged in customer data */
                $customer = $this->session->getCustomer();
                if ($customer) {
                    $this->cacheId = $customer->getId();
                }
            }
        }
        return $this->cacheId;
    }
}