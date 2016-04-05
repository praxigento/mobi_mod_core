<?php
/**
 * Empty class to get stub for tests
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Data\Entity\Type;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

define('ENTITY_NAME', 'test_entity');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    const DEF_CODE = 'test code';
    const DEF_ID = 21;
    const DEF_NOTE = 'test note';
    /** @var  Base */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = \Mockery::mock(Base::class . '[]');
    }

    public function test_accessors()
    {
        $this->obj->setId(self::DEF_ID);
        $this->obj->setCode(self::DEF_CODE);
        $this->obj->setNote(self::DEF_NOTE);
        $this->assertEquals(self::DEF_ID, $this->obj->getId());
        $this->assertEquals(self::DEF_CODE, $this->obj->getCode());
        $this->assertEquals(self::DEF_NOTE, $this->obj->getNote());
    }

    public function test_getPrimaryKeyAttrs()
    {
        $pk = $this->obj->getPrimaryKeyAttrs();
        $this->assertTrue(is_array($pk));
        $this->assertEquals(Base::ATTR_ID, reset($pk));
    }
}
