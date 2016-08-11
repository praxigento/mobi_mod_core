<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Magento\Framework\App\ObjectManager;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class TypePropertiesRegistry_ManualTest extends \Praxigento\Core\Test\BaseMockeryCase
{

    /** @var  \Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry */
    private $_obj;

    public function setUp()
    {
        parent::setUp();
        $this->_obj = ObjectManager::getInstance()->create(\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry::class);

    }

    public function test_normalizeType()
    {
        $typeNorm = 'Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry';
        $typeFull = '\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry';
        $typeArray = '\Praxigento\Core\Plugin\Framework\Webapi\Sub\TypePropertiesRegistry[]';
        $res = $this->_obj->normalizeType($typeNorm);
        $this->assertEquals($typeNorm, $res);
        $res = $this->_obj->normalizeType($typeFull);
        $this->assertEquals($typeNorm, $res);
        $res = $this->_obj->normalizeType($typeArray);
        $this->assertEquals($typeNorm, $res);
    }


}