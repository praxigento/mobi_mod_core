<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Web\Authenticator;

use Praxigento\Core\Api\App\Web\Request as ARequest;
use Praxigento\Core\Api\App\Web\Request\Dev as ADev;


/**
 * MOBI Authenticator for Web API REST requests.
 */
class Rest
    implements \Praxigento\Core\Api\App\Web\Authenticator\Rest
{
    /** @var int|bool|null */
    private $cacheId;
    /** @var \Praxigento\Core\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Authorization\Model\UserContextInterface */
    private $userCtx;

    public function __construct(
        \Magento\Authorization\Model\UserContextInterface $userCtx,
        \Praxigento\Core\Helper\Config $hlpCfg
    ) {
        $this->userCtx = $userCtx;
        $this->hlpCfg = $hlpCfg;
    }

    public function getCurrentUserId(ARequest $request = null)
    {
        if (is_null($this->cacheId)) {
            $this->cacheId = false; // to prevent execution reiteration for not logged in admins
            $offeredId = null;
            if ($request) {
                $offeredId = $request->get('/' . ARequest::DEV . '/' . ADev::ADMIN_ID);
            }
            if (
                $this->hlpCfg->getApiAuthenticationEnabledDevMode() &&
                !is_null($offeredId)
            ) {
                /* use offered user ID if MOBI API DevMode is enabled */
                $this->cacheId = (int)$offeredId;
            } else {
                /* get currently logged in REST user */
                $this->cacheId = $this->userCtx->getUserId();
            }
        }
        return $this->cacheId;
    }
}