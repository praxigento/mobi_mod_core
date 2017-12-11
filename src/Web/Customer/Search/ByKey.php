<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Web\Customer\Search;

use Praxigento\Core\Api\Web\Customer\Search\ByKey\Request as ARequest;
use Praxigento\Core\Api\Web\Customer\Search\ByKey\Response as AResponse;

class ByKey
    implements \Praxigento\Core\Api\Web\Customer\Search\ByKeyInterface
{
    /** @var \Praxigento\Core\Api\Service\Customer\Search */
    private $servCustSearch;

    public function __construct(
        \Praxigento\Core\Api\Service\Customer\Search $servCustSearch
    ) {
        $this->servCustSearch = $servCustSearch;
    }

    public function exec($request) {
        assert($request instanceof ARequest);
        /** define local working data */
        $data = $request->getData();
        $limit = $data->getLimit();
        $key = $data->getSearchKey();

        /** perform processing */
        $req = new \Praxigento\Core\Api\Service\Customer\Search\Request();
        $req->setLimit($limit);
        $req->setSearchKey($key);
        $resp = $this->servCustSearch->exec($req);
        $respData = $resp->getData();
        $items = $respData->getItems();

        /** compose result */
        $result = new AResponse();
        $dataOut = new AResponse\Data();
        $dataOut->setItems($items);
        $result->setData($dataOut);
        return $result;
    }
}