<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Transaction\Database\Def;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Definition_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{

    const CONN = 'connection name';
    const LEVEL = 'level';
    const NAME = 'transaction name';
    /** @var  Definition */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Definition(
            self::NAME,
            self::CONN,
            self::LEVEL
        );
    }

    public function test_constructor()
    {
        $this->assertInstanceOf(\Praxigento\Core\Transaction\Database\IDefinition::class, $this->obj);
    }

    public function test_accessors()
    {
        $this->assertEquals(self::NAME, $this->obj->getTransactionName());
        $this->assertEquals(self::CONN, $this->obj->getConnectionName());
        $this->assertEquals(self::LEVEL, $this->obj->getLevel());
    }
}