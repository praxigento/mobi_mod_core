<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper\Customer;

use Praxigento\Core\Config as Cfg;

/**
 * Customer groups related helper.
 */
class Group
    implements \Praxigento\Core\Api\Helper\Customer\Group
{
    /** @var \Praxigento\Core\Api\App\Repo\Generic */
    private $daoGeneric;

    public function __construct(
        \Praxigento\Core\Api\App\Repo\Generic $daoGeneric
    ) {
        $this->daoGeneric = $daoGeneric;
    }

    public function getIdByCustomerId($custId)
    {
        $result = null;
        if ($custId) {
            $entity = Cfg::ENTITY_MAGE_CUSTOMER;
            $pk = [Cfg::E_CUSTOMER_A_ENTITY_ID => $custId];
            $found = $this->daoGeneric->getEntityByPk($entity, $pk);
            if (is_array($found)) {
                $result = $found[Cfg::E_CUSTOMER_A_GROUP_ID];
            }
        }
        return $result;
    }
}