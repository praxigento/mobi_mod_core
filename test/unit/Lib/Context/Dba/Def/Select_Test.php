<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Dba\Def;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Select_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase {
    /** @var  \Mockery\MockInterface */
    private $mZend;
    /** @var  Select */
    private $obj;

    protected function setUp() {
        parent::setUp();
        $this->mZend = $this->_mock(\Zend_Db_Select::class);
        $this->obj = new Select($this->mZend);
    }

    public function test_from() {
        $this->mZend->shouldReceive('from');
        $this->obj->from('name', 'cols');
    }

    public function test_group() {
        $this->mZend->shouldReceive('group');
        $this->obj->group('spec');
    }

    public function test_joinLeft() {
        $this->mZend->shouldReceive('joinLeft');
        $this->obj->joinLeft('name', 'conds', 'cols');
    }

    public function test_limit() {
        $this->mZend->shouldReceive('limit');
        $this->obj->limit('count', 'offset');
    }

    public function test_order() {
        $this->mZend->shouldReceive('order');
        $this->obj->order('spec');
    }

    public function test_where() {
        $this->mZend->shouldReceive('where');
        $this->obj->where('cond', 'value');
    }

}