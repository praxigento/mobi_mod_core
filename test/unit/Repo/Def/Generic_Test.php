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
    /** @var  \Mockery\MockInterface */
    private $mResource;
    /** @var  Generic */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mResource = $this->_mockResourceConnection($this->mConn);
        /** create object to test */
        $this->obj = new Generic($this->mResource);
    }


    public function test_addEntity()
    {
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn('inserted');
        /** === Call and asserts  === */
        $resp = $this->obj->addEntity('entity', []);
        $this->assertEquals('inserted', $resp);
    }

    public function test_addEntity_dataObject()
    {
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn('inserted');
        /** === Call and asserts  === */
        $resp = $this->obj->addEntity('entity', new DataObject([]));
        $this->assertEquals('inserted', $resp);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertTrue($this->obj instanceof \Praxigento\Core\Repo\IGeneric);
    }

    public function test_deleteEntity()
    {
        /** === Test Data === */
        $ENTITY = 'entity';
        $WHERE = 'where';
        $TABLE = 'table';
        $DELETED = 32;
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $result = $this->_conn->delete($tbl, $where);
        $this->mConn
            ->shouldReceive('delete')->once()
            ->andReturn($DELETED);
        /** === Call and asserts  === */
        $resp = $this->obj->deleteEntity($ENTITY, $WHERE);
        $this->assertEquals($DELETED, $resp);
    }

    public function test_deleteEntityByPk()
    {
        /** === Test Data === */
        $ENTITY = 'entity';
        $TABLE = 'table';
        $PK = ['field' => 'value'];
        $ROWS_AFFECTED = 1;
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $result = $this->_conn->delete($tbl, $where);
        $this->mConn
            ->shouldReceive('delete')->once()
            ->andReturn($ROWS_AFFECTED);
        /** === Call and asserts  === */
        $resp = $this->obj->deleteEntityByPk($ENTITY, $PK);
    }

    public function test_getEntities()
    {
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once();
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
        /** === Call and asserts  === */
        $resp = $this->obj->getEntities('entity', null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk()
    {
        /** === Test Data === */
        $PK = [
            'field' => 'value'
        ];
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $query = $conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl, $cols);
        $mQuery->shouldReceive('from')->once();
        // $query->where($where);
        $mQuery->shouldReceive('where')->once()
            ->with('field=:field');
        // $result = $conn->fetchRow($query, $pk);
        $this->mConn
            ->shouldReceive('fetchRow')->once()
            ->andReturn('result');
        /** === Call and asserts  === */
        $resp = $this->obj->getEntityByPk('entity', $PK);
        $this->assertEquals('result', $resp);
    }

    public function test_replaceEntity()
    {
        /** === Test Data === */
        $BIND = ['key' => 'value'];
        $ID = 321;
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $this->_conn->query($query, $bind);
        $this->mConn
            ->shouldReceive('query')->once()
            ->andReturn('result');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn($ID);
        /** === Call and asserts  === */
        $id = $this->obj->replaceEntity('entity', $BIND);
        $this->assertEquals($ID, $id);
    }

    public function test_updateEntity()
    {
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $result = $this->_conn->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->andReturn('result');
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntity('entity', []);
        $this->assertEquals('result', $resp);
    }

    public function test_updateEntity_dataObject()
    {
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        // $result = $this->_conn->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->andReturn('result');
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntity('entity', new DataObject([]));
        $this->assertEquals('result', $resp);
    }

}
