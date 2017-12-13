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
    /** @var \Praxigento\Core\Api\Service\Customer\Get\ById */
    private $servCustGet;

    public function __construct(
        \Praxigento\Core\Api\Service\Customer\Get\ById $servCustGet
    ) {
        $this->servCustGet = $servCustGet;
    }

    public function exec($request) {
        assert($request instanceof ARequest);
        /** define local working data */
        $data = $request->getData();
        $dev = $request->getDev();
        $email = $data->getEmail();
        $custId = $dev->getCustId();

        /* TODO: add request authorization */
        $isAdminRequest = false;
        $requesterId = $custId;

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