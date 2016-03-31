<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Dba\Def;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Connection_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase {
    /** @var  \Mockery\MockInterface */
    private $mZend;
    /** @var  Select */
    private $obj;

    protected function setUp() {
        parent::setUp();
        $this->mZend = $this->_mock(\Zend_Db_Adapter_Abstract::class);
        $this->obj = new Connection($this->mZend);
    }

    public function test_beginTransaction() {
        $this->mZend->shouldReceive('beginTransaction');
        $this->obj->beginTransaction();
    }

    public function test_commit() {
        $this->mZend->shouldReceive('commit');
        $this->obj->commit();
    }

    public function test_fetchAll() {
        $this->mZend->shouldReceive('fetchAll')->once()->with('sql', 'bind')->andReturn('result');
        $resp = $this->obj->fetchAll('sql', 'bind');
        $this->assertEquals('result', $resp);
    }

    public function test_fetchOne() {
        $this->mZend->shouldReceive('fetchOne')->once()->with('sql', 'bind')->andReturn('result');
        $resp = $this->obj->fetchOne('sql', 'bind');
        $this->assertEquals('result', $resp);
    }

    public function test_fetchRow() {
        $this->mZend->shouldReceive('fetchRow')->once()->with('sql', 'bind')->andReturn('result');
        $resp = $this->obj->fetchRow('sql', 'bind');
        $this->assertEquals('result', $resp);
    }

    public function test_rollBack() {
        $this->mZend->shouldReceive('rollBack');
        $this->obj->rollBack();
    }

    public function test_select() {
        $mSelect = $this->_mock(\Zend_Db_Select::class);
        $this->mZend
            ->shouldReceive('select')->once()
            ->andReturn($mSelect);
        $resp = $this->obj->select();
        $this->assertInstanceOf(Select::class, $resp);
    }


}