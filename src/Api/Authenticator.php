<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api;

use \Praxigento\Core\Config as Cfg;

/**
 * Default implementation for REST API authenticator.
 */
class Authenticator
    implements \Praxigento\Core\Api\IAuthenticator
{
    /** @var \Magento\Customer\Model\Session */
    protected $sessCustomer;

    public function __construct(
        \Magento\Customer\Model\Session $sessCustomer
    ) {
        $this->sessCustomer = $sessCustomer;
    }

    public function getCurrentUserData()
    {
        $customer = $this->sessCustomer->getCustomer();
        if ($customer) {
            $data = $customer->getData();
            $result = new \Flancer32\Lib\Data($data);
        } else {
            $result = new \Flancer32\Lib\Data();
        }
        return $result;
    }

    public function isAuthenticated()
    {
        $result = $this->sessCustomer->isLoggedIn();
        return $result;
    }

    public function getCurrentUserId()
    {
        $data = $this->getCurrentUserData();
        $result = $data->get(Cfg::E_CUSTOMER_A_ENTITY_ID);
        return $result;
    }
}