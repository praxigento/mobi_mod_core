<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\DataObject;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Generic_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Generic */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new Generic($mResource);
    }


    public function test_addEntity()
    {
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->with('table', [])
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
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
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->with('table', [])
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
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
        /* === Call and asserts  === */
        $this->assertTrue($this->obj instanceof \Praxigento\Core\Repo\IGeneric);
    }

    public function test_deleteEntityByPk()
    {
        /* === Test Data === */
        $ENTITY = 'entity';
        $TABLE = 'table';
        $PK = ['field' => 'value'];
        $ROWS_AFFECTED = 1;
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->with($ENTITY)
            ->andReturn($TABLE);
        // $result = $this->_conn->delete($tbl, $where);
        $this->mConn
            ->shouldReceive('delete')->once()
            ->with($TABLE, ['field=?' => 'value'])
            ->andReturn($ROWS_AFFECTED);
        /* === Call and asserts  === */
        $resp = $this->obj->deleteEntityByPk($ENTITY, $PK);
    }

    public function test_getEntities()
    {
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $query = $this->_conn->select();
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
        // $result = $this->_conn->fetchAll($query);
        $this->mConn
            ->shouldReceive('fetchAll')->once()
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->getEntities('entity', null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk()
    {
        /* === Test Data === */
        $PK = [
            'field' => 'value'
        ];
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
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
        /* === Test Data === */
        $BIND = ['key' => 'value'];
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $this->_conn->query($query, $bind);
        $this->mConn
            ->shouldReceive('query')->once()
            ->with('REPLACE table (key) VALUES (:key)', anything())
            ->andReturn('result');
        /* === Call and asserts  === */
        $this->obj->replaceEntity('entity', $BIND);
    }

    public function test_updateEntity()
    {
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_conn->update($tbl, $bind, $where);
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
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->andReturn('table');
        // $result = $this->_conn->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->with('table', [], null)
            ->andReturn('result');
        /* === Call and asserts  === */
        $resp = $this->obj->updateEntity('entity', new DataObject([]));
        $this->assertEquals('result', $resp);
    }

}
