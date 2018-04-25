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
    private $daoGeneric;

    public function __construct(
        \Praxigento\Core\Api\App\Repo\Generic $daoGeneric
    ) {
        $this->daoGeneric = $daoGeneric;
    }


    public function exec($request)
    {
        assert($request instanceof ARequest);
        /** define local working data */
        $customerId = $request->getCustomerId();
        $email = $request->getEmail();

        /** perform processing */
        if ($customerId) {
            /* customer ID has a higher priority */
            $result = $this->searchById($customerId);
        } elseif ($email) {
            /* ... then search by email */
            $result = $this->searchByEmail($email);
        } else {
            $result = new AResponse(); // empty result
        }

        /** compose result */
        return $result;
    }

    private function searchByEmail($email)
    {
        $conn = $this->daoGeneric->getConnection();
        $cols = null; // all columns
        $quoted = $conn->quote($email);
        $where = Cfg::E_CUSTOMER_A_EMAIL . '=' . $quoted;
        $entries = $this->daoGeneric->getEntities(Cfg::ENTITY_MAGE_CUSTOMER, $cols, $where);
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

    private function searchById($id)
    {
        $pk = [Cfg::E_CUSTOMER_A_ENTITY_ID => (int)$id];
        $entry = $this->daoGeneric->getEntityByPk(Cfg::ENTITY_MAGE_CUSTOMER, $pk);
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