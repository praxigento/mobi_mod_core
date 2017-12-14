<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Customer\Get;

use Praxigento\Core\Api\Service\Customer\Get\ById\Request as ARequest;
use Praxigento\Core\Api\Service\Customer\Get\ById\Response as AResponse;
use Praxigento\Core\Config as Cfg;

class ById
    implements \Praxigento\Core\Api\Service\Customer\Get\ById
{
    private $repoGeneric;

    public function __construct(
        \Praxigento\Core\App\Repo\IGeneric $repoGeneric
    ) {
        $this->repoGeneric = $repoGeneric;
    }


    public function exec($request) {
        assert($request instanceof ARequest);
        /** define local working data */
        $customerId = $request->getCustomerId();
        $email = $request->getEmail();
        $ignoreRequester = $request->getIgnoreRequester();
        $requesterId = $request->getRequesterId();

        /** perform processing */
        /* TODO: add search by email for frontend requests (when customerId is not set) */
        if (
            $ignoreRequester ||
            ($customerId == $requesterId)
        ) {
            /* process if this is admin request or customer requests info for itself */
            if ($customerId) {
                /* customer ID has a higher priority */
                $result = $this->searchById($customerId);
            } elseif ($email) {
                /* ... then search by email */
                $result = $this->searchByEmail($email);
            } else {
                $result = new AResponse(); // empty result
            }
        }

        /** compose result */
        return $result;
    }

    private function searchByEmail($email) {
        $conn = $this->repoGeneric->getConnection();
        $cols = null; // all columns
        $quoted = $conn->quote($email);
        $where = Cfg::E_CUSTOMER_A_EMAIL . '=' . $quoted;
        $entries = $this->repoGeneric->getEntities(Cfg::ENTITY_MAGE_CUSTOMER, $cols, $where);
        $result = new AResponse();
        if (count($entries) == 1) {
            $entry = reset($entries);
            $email = $entry[Cfg::E_CUSTOMER_A_EMAIL];
            $first = $entry[Cfg::E_CUSTOMER_A_FIRSTNAME];
            $id = $entry[Cfg::E_CUSTOMER_A_ENTITY_ID];
            $last = $entry[Cfg::E_CUSTOMER_A_LASTNAME];
            $result->setEmail($email);
            $result->setId($id);
            $result->setNameFirst($first);
            $result->setNameLast($last);
        }
        return $result;
    }

    private function searchById($id) {
        $pk = [Cfg::E_CUSTOMER_A_ENTITY_ID => (int)$id];
        $entry = $this->repoGeneric->getEntityByPk(Cfg::ENTITY_MAGE_CUSTOMER, $pk);
        $result = new AResponse();
        if ($entry) {
            $email = $entry[Cfg::E_CUSTOMER_A_EMAIL];
            $first = $entry[Cfg::E_CUSTOMER_A_FIRSTNAME];
            $id = $entry[Cfg::E_CUSTOMER_A_ENTITY_ID];
            $last = $entry[Cfg::E_CUSTOMER_A_LASTNAME];
            $result->setEmail($email);
            $result->setId($id);
            $result->setNameFirst($first);
            $result->setNameLast($last);
        }
        return $result;
    }
}