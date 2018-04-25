<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo;

use Magento\Framework\App\ObjectManager;
use Praxigento\Accounting\Repo\Data\Account as DataEntity;
use Praxigento\Accounting\Repo\Data\Operation as DataEntityOther;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Entity_ManualTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  \Praxigento\Core\App\Repo\Dao */
    private $_obj;
    private $_obj2;

    public function setUp()
    {
        parent::setUp();
        $resource = ObjectManager::getInstance()->get(\Magento\Framework\App\ResourceConnection::class);
        $daoGeneric = ObjectManager::getInstance()->get(\Praxigento\Core\Api\App\Repo\Generic::class);
        $this->_obj = new Dao($resource, $daoGeneric, DataEntity::class);
        $this->_obj2 = new Dao($resource, $daoGeneric, DataEntityOther::class);
    }

    public function test_create()
    {
        $bind = [
            DataEntity::A_ASSET_TYPE_ID => 1,
            DataEntity::A_CUST_ID => 1
        ];
        $res = $this->_obj->create($bind);
        $this->assertTrue($res > 0);
        $bind = [
            DataEntityOther::A_TYPE_ID => 1
        ];
        $res = $this->_obj2->create($bind);
        $this->assertTrue($res > 0);
    }


}