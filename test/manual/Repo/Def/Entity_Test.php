<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Magento\Framework\App\ObjectManager;
use Praxigento\Accounting\Data\Entity\Account as DataEntity;
use Praxigento\Accounting\Data\Entity\Operation as DataEntityOther;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Entity_ManualTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  \Praxigento\Core\Repo\Def\Entity */
    private $_obj;
    private $_obj2;

    public function setUp()
    {
        parent::setUp();
        $resource = ObjectManager::getInstance()->get(\Magento\Framework\App\ResourceConnection::class);
        $repoGeneric = ObjectManager::getInstance()->get(\Praxigento\Core\Repo\IGeneric::class);
        $this->_obj = new Entity($resource, $repoGeneric, DataEntity::class);
        $this->_obj2 = new Entity($resource, $repoGeneric, DataEntityOther::class);
    }

    public function test_create()
    {
        $bind = [
            DataEntity::ATTR_ASSET_TYPE_ID => 1,
            DataEntity::ATTR_CUST_ID => 1
        ];
        $res = $this->_obj->create($bind);
        $this->assertTrue($res > 0);
        $bind = [
            DataEntityOther::ATTR_TYPE_ID => 1
        ];
        $res = $this->_obj2->create($bind);
        $this->assertTrue($res > 0);
    }


}