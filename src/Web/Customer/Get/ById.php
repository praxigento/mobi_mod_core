<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Web\Customer\Get;

use Praxigento\Core\Api\Web\Customer\Get\ById\Request as ARequest;
use Praxigento\Core\Api\Web\Customer\Get\ById\Response as AResponse;

class ById
    implements \Praxigento\Core\Api\Web\Customer\Get\ByIdInterface
{
    /** @var \Praxigento\Core\App\Api\Web\IAuthenticator */
    private $authenticator;
    /** @var \Praxigento\Core\Api\Service\Customer\Get\ById */
    private $servCustGet;

    public function __construct(
        \Praxigento\Core\App\Api\Web\Authenticator\Front $authenticator,
        \Praxigento\Core\Api\Service\Customer\Get\ById $servCustGet
    ) {
        $this->authenticator = $authenticator;
        $this->servCustGet = $servCustGet;
    }

    public function exec($request)
    {
        assert($request instanceof ARequest);
        /** define local working data */

        /**
         * Customer can access his own data by ID only in core service.
         */
        /* pre-authorization */
        $currentCustId = $this->authenticator->getCurrentUserId($request);
        if (!$currentCustId) {
            $phrase = new \Magento\Framework\Phrase('User is not authorized to perform this operation.');
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new \Magento\Framework\Exception\AuthorizationException($phrase);
        }

        /** perform processing */
        $req = new \Praxigento\Core\Api\Service\Customer\Get\ById\Request();
        $req->setCustomerId($currentCustId);
        $resp = $this->servCustGet->exec($req);

        /** compose result */
        $result = new AResponse();
        $result->setData($resp);
        return $result;
    }
}