<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo\Def;

use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Context\Dba\Def\Select;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Basic_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mDba;
    /** @var  \Mockery\MockInterface */
    private $mRsrcConn;
    /** @var  Basic */
    private $repo;

    protected function setUp()
    {
        parent::setUp();
        $this->markTestSkipped('Test is deprecated after M1 & M2 merge is done.');
        $this->mDba = $this->_mockDba();
        $this->mRsrcConn = $this->_mockResourceConnection($this->mDba);
        $this->repo = new Basic($this->mRsrcConn);
    }

    public function test_addEntity()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_dba->insert($tbl, $bind);
        $this->mDba
            ->shouldReceive('insert')->once()
            ->with('table', [])
            ->andReturn('added');
        // $result = $this->_dba->lastInsertId($tbl);
        $this->mDba
            ->shouldReceive('lastInsertId')->once()
            ->with('table')
            ->andReturn('inserted');
        //
        $resp = $this->repo->addEntity('entity', []);
        $this->assertEquals('inserted', $resp);
    }

    public function test_getEntities()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $this->_dba->select();
        $mQuery = $this->_mockDbSelect();
        $this->mDba
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
        // $result = $this->_dba->fetchAll($query);
        $this->mDba
            ->shouldReceive('fetchAll')->once()
            ->andReturn('result');
        //
        $resp = $this->repo->getEntities('entity', null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk()
    {
        $PK = [
            'field' => 'value'
        ];
        // $tbl = $this->_dba->getTableName($entity);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mDba
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once()
            ->with('table', Select::SQL_WILDCARD);
        // $query->where($where);
        $mQuery->shouldReceive('where')->once()
            ->with('field=:field');
        // $result = $conn->fetchRow($query, $pk);
        $this->mDba
            ->shouldReceive('fetchRow')->once()
            ->andReturn('result');
        //
        $resp = $this->repo->getEntityByPk('entity', $PK);
        $this->assertEquals('result', $resp);
    }

    public function test_replaceEntity()
    {
        $BIND = ['key' => 'value'];
        // $tbl = $this->_dba->getTableName($entity);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $this->_dba->query($query, $bind);
        $this->mDba
            ->shouldReceive('query')->once()
            ->with('REPLACE table (key) VALUES (:key)', anything())
            ->andReturn('result');
        //
        $this->repo->replaceEntity('entity', $BIND);
    }

    public function test_updateEntity()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mDba
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_dba->update($tbl, $bind, $where);
        $this->mDba
            ->shouldReceive('update')->once()
            ->with('table', [], null)
            ->andReturn('result');
        //
        $resp = $this->repo->updateEntity('entity', []);
        $this->assertEquals('result', $resp);
    }


}