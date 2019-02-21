<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Web\Authenticator;

use Praxigento\Core\Api\App\Web\Request as ARequest;
use Praxigento\Core\Api\App\Web\Request\Dev as ADev;

/**
 * MOBI Authenticator for frontend (regular customer authentication).
 */
class Front
    implements \Praxigento\Core\Api\App\Web\Authenticator\Front
{
    /** @var int|bool|null */
    private $cacheId = false;
    /** @var \Praxigento\Core\Helper\Config */
    private $hlpCfg;
    /** @var bool forced development authentication flag */
    private $isDevAuthForced = false;
    /** @var \Magento\Customer\Model\Session */
    private $session;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->session = $session;
        $this->hlpCfg = $hlpCfg;
    }

    public function forceDevAuthentication()
    {
        $this->isDevAuthForced = true;
    }

    public function getCurrentUserId(ARequest $request = null)
    {
        $result = null;
        /* $cacheId can be equal to 'null' if customer is anonymous */
        if ($this->cacheId === false) {
            /* get currently logged in customer data */
            $customer = $this->session->getCustomer();
            if ($customer) {
                $this->cacheId = $customer->getId();
                $result = $this->cacheId;
            }
            /* get ID from request if session is not established */
            if (!$this->cacheId) {
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
                    $result = $this->cacheId;
                    /* forced re-authentication from CLI batch processing */
                    if ($this->isDevAuthForced) {
                        $this->cacheId = false;
                    }
                }
            }
        } else {
            $result = $this->cacheId;
        }
        return $result;
    }
}