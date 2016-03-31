<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo\Def;

use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Context\Dba\Def\Select;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Basic_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase {
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mDba;
    /** @var  Basic */
    private $repo;

    protected function setUp() {
        parent::setUp();
        $this->mConn = $this->_mockConnection();
        $this->mDba = $this->_mockDba($this->mConn);
        $this->repo = new Basic($this->mDba);
    }

    public function test_addEntity() {
        // $tbl = $this->_getTableName($entityName);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_getConn()->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->with('table', 'bind')
            ->andReturn('added');
        // $result = $this->_getConn()->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->with('table')
            ->andReturn('inserted');
        //
        $resp = $this->repo->addEntity('entity', 'bind');
        $this->assertEquals('inserted', $resp);
    }

    public function test_getDba() {
        $resp = $this->repo->getDba();
        $this->assertInstanceOf(\Praxigento\Core\Lib\Context\IDbAdapter::class, $resp);
    }

    public function test_getEntities() {
        // $tbl = $this->_getTableName($entityName);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $this->_getConn()->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once()
               ->with('table', Select::SQL_WILDCARD);
        // $query->where($where);
        $mQuery->shouldReceive('where')->once()
               ->with('where');
        // $query->order($order);
        $mQuery->shouldReceive('order')->once()
               ->with('order');
        // $query->limit($limit, $offset);
        $mQuery->shouldReceive('limit')->once()
               ->with('limit', 'offset');
        // $result = $this->_getConn()->fetchAll($query);
        $this->mConn
            ->shouldReceive('fetchAll')->once()
            ->andReturn('result');
        //
        $resp = $this->repo->getEntities('entity', null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk() {
        $PK = [
            'field' => 'value'
        ];
        // $tbl = $this->_getTableName($entityName);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once()
               ->with('table', Select::SQL_WILDCARD);
        // $query->where($where);
        $mQuery->shouldReceive('where')->once()
               ->with('field=:field');
        // $result = $conn->fetchRow($query, $pk);
        $this->mConn
            ->shouldReceive('fetchRow')->once()
            ->andReturn('result');
        //
        $resp = $this->repo->getEntityByPk('entity', $PK);
        $this->assertEquals('result', $resp);
    }

    public function test_replaceEntity() {
        $BIND = [ 'key' => 'value' ];
        // $tbl = $this->_getTableName($entityName);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $this->_getConn()->query($query, $bind);
        $this->mConn
            ->shouldReceive('query')->once()
            ->with('REPLACE table (key) VALUES (:key)', anything())
            ->andReturn('result');
        //
        $this->repo->replaceEntity('entity', $BIND);
    }

    public function test_updateEntity() {
        // $tbl = $this->_getTableName($entityName);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_getConn()->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->with('table', 'bind', null)
            ->andReturn('result');
        //
        $resp = $this->repo->updateEntity('entity', 'bind');
        $this->assertEquals('result', $resp);
    }


}