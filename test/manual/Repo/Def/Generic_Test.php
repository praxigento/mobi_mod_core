<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Magento\Framework\App\ObjectManager;
use Praxigento\Bonus\Base\Lib\Entity\Type\Calc;


include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Generic_ManualTest extends \Praxigento\Core\Test\BaseMockeryCase
{

    /** @var  \Praxigento\Core\Repo\Def\Generic */
    private $_obj;

    public function setUp()
    {
        parent::setUp();
        $this->_obj = ObjectManager::getInstance()->get(\Praxigento\Core\Repo\Def\Generic::class);

    }

    public function test_addEntity()
    {
        $entity = Calc::ENTITY_NAME;
        $bind = [
            Calc::ATTR_CODE => 'code',
            Calc::ATTR_NOTE => 'note'
        ];
        $resp = $this->_obj->addEntity($entity, $bind);
        $this->assertNotNull($resp);
    }

    public function test_construct()
    {
        $this->assertTrue($this->_obj instanceof \Praxigento\Core\Repo\Def\Generic);
    }

    public function test_getEntities()
    {
        $entity = Calc::ENTITY_NAME;
        $resp = $this->_obj->getEntities($entity);
        $this->assertTrue(is_array($resp));
    }

    public function test_getEntityByPk()
    {
        $entity = Calc::ENTITY_NAME;
        $pk = [Calc::ATTR_ID => 1];
        $resp = $this->_obj->getEntityByPk($entity, $pk);
        $this->assertTrue(is_array($resp));
    }

}