<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\DataObject;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Basic_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Basic */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoBasic = $this->_mockRepoBasic();
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new Basic($mResource);
    }


    public function test_addEntity()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_dba->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->with('table', [])
            ->andReturn('added');
        // $result = $this->_dba->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->with('table')
            ->andReturn('inserted');
        /* === Call and asserts  === */
        $resp = $this->obj->addEntity('entity', []);
        $this->assertEquals('inserted', $resp);
    }

    public function test_addEntity_dataObject()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_dba->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->with('table', [])
            ->andReturn('added');
        // $result = $this->_dba->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->with('table')
            ->andReturn('inserted');
        /* === Call and asserts  === */
        $resp = $this->obj->addEntity('entity', new DataObject([]));
        $this->assertEquals('inserted', $resp);
    }

    public function test_constructor()
    {
        /* === Test Data === */
        /* === Setup Mocks === */
        /* === Call and asserts  === */
        $this->assertTrue($this->obj instanceof \Praxigento\Core\Repo\Def\Base);
    }

    public function test_getEntities()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $this->_dba->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once()
            ->with('table', \Zend_Db_Select::SQL_WILDCARD);
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
        $this->mConn
            ->shouldReceive('fetchAll')->once()
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->getEntities('entity', null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk()
    {
        $PK = [
            'field' => 'value'
        ];
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once()
            ->with('table', \Zend_Db_Select::SQL_WILDCARD);
        // $query->where($where);
        $mQuery->shouldReceive('where')->once()
            ->with('field=:field');
        // $result = $conn->fetchRow($query, $pk);
        $this->mConn
            ->shouldReceive('fetchRow')->once()
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->getEntityByPk('entity', $PK);
        $this->assertEquals('result', $resp);
    }

    public function test_replaceEntity()
    {
        $BIND = ['key' => 'value'];
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $this->_dba->query($query, $bind);
        $this->mConn
            ->shouldReceive('query')->once()
            ->with('REPLACE table (key) VALUES (:key)', anything())
            ->andReturn('result');
        /* === Call and asserts  === */
        $this->obj->replaceEntity('entity', $BIND);
    }

    public function test_updateEntity()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_dba->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->with('table', [], null)
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->updateEntity('entity', []);
        $this->assertEquals('result', $resp);
    }

    public function test_updateEntity_dataObject()
    {
        // $tbl = $this->_dba->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_dba->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->with('table', [], null)
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->updateEntity('entity', new DataObject([]));
        $this->assertEquals('result', $resp);
    }

}
