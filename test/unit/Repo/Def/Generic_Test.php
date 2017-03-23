<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Flancer32\Lib\Data as DataObject;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Generic_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Repo
{
    /** @var  Generic */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new Generic(
            $this->mResource
        );
    }


    public function test_addEntity()
    {
        /** === Test Data === */
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn('inserted');
        /** === Call and asserts  === */
        $resp = $this->obj->addEntity($entity, []);
        $this->assertEquals('inserted', $resp);
    }

    public function test_addEntity_dataObject()
    {
        /** === Test Data === */
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $rowsAdded = $this->_conn->insert($tbl, $bind);
        $this->mConn
            ->shouldReceive('insert')->once()
            ->andReturn('added');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn('inserted');
        /** === Call and asserts  === */
        $resp = $this->obj->addEntity($entity, new DataObject([]));
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
        $entity = 'entity';
        $where = 'where';
        $table = 'table';
        $deleted = 32;
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $result = $this->_conn->delete($tbl, $where);
        $this->mConn
            ->shouldReceive('delete')->once()
            ->andReturn($deleted);
        /** === Call and asserts  === */
        $resp = $this->obj->deleteEntity($entity, $where);
        $this->assertEquals($deleted, $resp);
    }

    public function test_deleteEntityByPk()
    {
        /** === Test Data === */
        $ent = 'entity';
        $table = 'table';
        $pkey = ['field' => 'value'];
        $rowsAffected = 1;
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($ent)
            ->andReturn($table);
        // $result = $this->_conn->delete($tbl, $where);
        $this->mConn
            ->shouldReceive('delete')->once()
            ->andReturn($rowsAffected);
        /** === Call and asserts  === */
        $resp = $this->obj->deleteEntityByPk($ent, $pkey);
        $this->assertEquals($rowsAffected, $resp);
    }

    public function test_getEntities()
    {
        /** === Test Data === */
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
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
        $resp = $this->obj->getEntities($entity, null, 'where', 'order', 'limit', 'offset');
        $this->assertEquals('result', $resp);
    }

    public function test_getEntityByPk()
    {
        /** === Test Data === */
        $pkey = [
            'field' => 'value'
        ];
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
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
        $resp = $this->obj->getEntityByPk($entity, $pkey);
        $this->assertEquals('result', $resp);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function test_replaceEntity()
    {
        /** === Test Data === */
        $bind = ['key' => 'value'];
        $id = 321;
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $this->_conn->query($query, $bind);
        $this->mConn
            ->shouldReceive('query')->once()
            ->andReturn('result');
        // $result = $this->_conn->lastInsertId($tbl);
        $this->mConn
            ->shouldReceive('lastInsertId')->once()
            ->andReturn($id);
        /** === Call and asserts  === */
        $id = $this->obj->replaceEntity($entity, $bind);
        $this->assertEquals($id, $id);
    }

    public function test_updateEntity()
    {
        /** === Test Data === */
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $result = $this->_conn->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->andReturn('result');
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntity($entity, []);
        $this->assertEquals('result', $resp);
    }

    public function test_updateEntity_dataObject()
    {
        /** === Test Data === */
        $entity = 'entity';
        $table = 'table';
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($table);
        // $result = $this->_conn->update($tbl, $bind, $where);
        $this->mConn
            ->shouldReceive('update')->once()
            ->andReturn('result');
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntity($entity, new DataObject([]));
        $this->assertEquals('result', $resp);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function test_updateEntityById()
    {
        /** === Test Data === */
        $entity = 'entity';
        $bind = [];
        $key = 'key';
        $value = 'value';
        $id = [$key => $value];
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $mTable = 'table';
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($mTable);
        // $where .= " AND $field=" . $this->_conn->quote($value);
        $this->mConn
            ->shouldReceive('quote')->once()
            ->with($value)
            ->andReturn($value);
        // $result = $this->_conn->update($tbl, $data, $where);
        $mResult = 'result';
        $this->mConn
            ->shouldReceive('update')->once()
            ->with($mTable, $bind, "1 AND $key=$value")
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntityById($entity, $bind, $id);
        $this->assertEquals($mResult, $resp);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function test_updateEntityById_isDataObject()
    {
        /** === Test Data === */
        $entity = 'entity';
        $objData = [];
        $bind = new DataObject($objData);
        $key = 'key';
        $value = 'value';
        $id = [$key => $value];
        /** === Setup Mocks === */
        // $tbl = $this->_resource->getTableName($entity);
        $mTable = 'table';
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($entity)
            ->andReturn($mTable);
        // $where .= " AND $field=" . $this->_conn->quote($value);
        $this->mConn
            ->shouldReceive('quote')->once()
            ->with($value)
            ->andReturn($value);
        // $result = $this->_conn->update($tbl, $data, $where);
        $mResult = 'result';
        $this->mConn
            ->shouldReceive('update')->once()
            ->with($mTable, $objData, "1 AND $key=$value")
            ->andReturn($mResult);
        /** === Call and asserts  === */
        $resp = $this->obj->updateEntityById($entity, $bind, $id);
        $this->assertEquals($mResult, $resp);
    }

}
