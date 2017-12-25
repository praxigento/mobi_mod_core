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
        \Praxigento\Core\App\Api\Web\IAuthenticator $authenticator,
        \Praxigento\Core\Api\Service\Customer\Get\ById $servCustGet
    ) {
        $this->authenticator = $authenticator;
        $this->servCustGet = $servCustGet;
    }

    public function exec($request) {
        assert($request instanceof ARequest);
        /** define local working data */
        $data = $request->getData();
        $custId = $data->getCustomerId();
        $email = $data->getEmail();

        /* get currently logged in users */
        $currentAdminId = $this->authenticator->getCurrentAdminId($request);
        $currentCustId = $this->authenticator->getCurrentUserId($request);

        /* analyze logged in users */
        if ($currentCustId) {
            /* this is customer session */
            $custId = $currentCustId;
            $requesterId = $currentCustId;
            $email = null;
            $isAdminRequest = false;
        } elseif ($currentAdminId) {
            $isAdminRequest = true;
        }

        /** perform processing */
        $req = new \Praxigento\Core\Api\Service\Customer\Get\ById\Request();
        $req->setCustomerId($custId);
        $req->setEmail($email);
        $req->setIgnoreRequester($isAdminRequest);
        $req->setRequesterId($requesterId);
        $resp = $this->servCustGet->exec($req);

        /** compose result */
        $result = new AResponse();
        $result->setData($resp);
        return $result;
    }
}