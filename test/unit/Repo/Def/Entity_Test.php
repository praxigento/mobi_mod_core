<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\IEntity;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Entity_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    private $ENTITY_NAME = TestEntity::ENTITY_NAME;
    private $PK = [TestEntity::ATTR_ID];
    private $PK_ATTR = TestEntity::ATTR_ID;
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mEntity;
    /** @var  \Mockery\MockInterface */
    private $mRepoGeneric;
    /** @var  Entity */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoGeneric = $this->_mockRepoGeneric();
        /* setup mocks for constructor */
        // parent::__construct($resource);
        $mResource = $this->_mockResourceConnection($this->mConn);
        /* create object */
        $this->obj = new Entity(
            $mResource,
            $this->mRepoGeneric,
            TestEntity::class
        );
    }

    public function test_constructor()
    {
        /* === Call and asserts  === */
        $this->assertTrue($this->obj instanceof \Praxigento\Core\Repo\IEntity);
    }

    public function test_create()
    {
        /* === Test Data === */
        $DATA = ['field' => 'value'];
        $ID = 'inserted';
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->addEntity($this->_entityName, $data);
        $this->mRepoGeneric
            ->shouldReceive('addEntity')->once()
            ->with($this->ENTITY_NAME, $DATA)
            ->andReturn($ID);
        /* === Call and asserts  === */
        $res = $this->obj->create($DATA);
        $this->assertEquals($ID, $res);
    }

    public function test_deleteById_array()
    {
        /* === Test Data === */
        $ID = ['pk1' => 'value1', 'pk2' => 'value2'];
        $DELETED = 1;
        /* === Setup Mocks === */
        // $result = $this->_repoBasic->deleteEntityByPk($this->_entityName, $pk);
        $this->mRepoGeneric
            ->shouldReceive('deleteEntityByPk')->once()
            ->with($this->ENTITY_NAME, $ID)
            ->andReturn($DELETED);
        /* === Call and asserts  === */
        $res = $this->obj->deleteById($ID);
        $this->assertEquals($DELETED, $res);
    }

    public function test_deleteById_notArray()
    {
        /* === Test Data === */
        $ID = 'simple';
        $DELETED = 1;
        /* === Setup Mocks === */
        // $result = $this->_repoBasic->deleteEntityByPk($this->_entityName, $pk);
        $this->mRepoGeneric
            ->shouldReceive('deleteEntityByPk')->once()
            ->with($this->ENTITY_NAME, [$this->PK_ATTR => $ID])
            ->andReturn($DELETED);
        /* === Call and asserts  === */
        $res = $this->obj->deleteById($ID);
        $this->assertEquals($DELETED, $res);
    }

    public function test_get()
    {
        /* === Test Data === */
        $WHERE = 'where';
        $ORDER = 'order';
        $LIMIT = 'limit';
        $OFFSET = 'offset';
        $DATA = [[1], [2]];
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->getEntities($this->_entityName, null, $where, $order, $limit, $offset);
        $this->mRepoGeneric
            ->shouldReceive('getEntities')->once()
            ->with($this->ENTITY_NAME, null, $WHERE, $ORDER, $LIMIT, $OFFSET)
            ->andReturn($DATA);
        /* === Call and asserts  === */
        $res = $this->obj->get($WHERE, $ORDER, $LIMIT, $OFFSET);
        $this->assertEquals($DATA, $res);
    }

    public function test_getById_array()
    {
        /* === Test Data === */
        $ID = ['pk1' => 'value1', 'pk2' => 'value2'];
        $DATA = [[1], [2]];
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->getEntityByPk($this->_entityName, $pk);
        $this->mRepoGeneric
            ->shouldReceive('getEntityByPk')->once()
            ->with($this->ENTITY_NAME, $ID)
            ->andReturn($DATA);
        /* === Call and asserts  === */
        $res = $this->obj->getById($ID);
        $this->assertEquals($DATA, $res);
    }

    public function test_getById_notArray()
    {
        /* === Test Data === */
        $ID = 'simple';
        $DATA = [[1], [2]];
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->getEntityByPk($this->_entityName, $pk);
        $this->mRepoGeneric
            ->shouldReceive('getEntityByPk')->once()
            ->with($this->ENTITY_NAME, [$this->PK_ATTR => $ID])
            ->andReturn($DATA);
        /* === Call and asserts  === */
        $res = $this->obj->getById($ID);
        $this->assertEquals($DATA, $res);
    }

    public function test_getRef()
    {
        /* === Call and asserts  === */
        $res = $this->obj->getRef();
        $this->assertInstanceOf(IEntity::class, $res);
    }

    public function test_update()
    {
        /* === Test Data === */
        $DATA = ['field' => 'value'];
        $WHERE = 'where';
        $UPDATED = 'rows updated';
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        $this->mRepoGeneric
            ->shouldReceive('updateEntity')->once()
            ->with($this->ENTITY_NAME, $DATA, $WHERE)
            ->andReturn($UPDATED);
        /* === Call and asserts  === */
        $res = $this->obj->update($DATA, $WHERE);
        $this->assertEquals($UPDATED, $res);
    }

    public function test_updateById_array()
    {
        /* === Test Data === */
        $ID = ['key1' => 43, 'key2' => 'string'];
        $DATA = [[1], [2]];
        $UPDATED = 'rows updated';
        /* === Setup Mocks === */
        // $val = is_int($value) ? $value : $this->_conn->quote($value);
        $this->mConn
            ->shouldReceive('quote')->once()
            ->andReturn("'string'");
        // $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        $this->mRepoGeneric
            ->shouldReceive('updateEntity')->once()
            ->with($this->ENTITY_NAME, $DATA, "(key1=43) AND (key2='string') AND 1")
            ->andReturn($UPDATED);
        /* === Call and asserts  === */
        $res = $this->obj->updateById($DATA, $ID);
        $this->assertEquals($UPDATED, $res);
    }

    public function test_updateById_int()
    {
        /* === Test Data === */
        $ID = 32;
        $DATA = [[1], [2]];
        $UPDATED = 'rows updated';
        /* === Setup Mocks === */
        // $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        $this->mRepoGeneric
            ->shouldReceive('updateEntity')->once()
            ->with($this->ENTITY_NAME, $DATA, $this->PK_ATTR . "=$ID")
            ->andReturn($UPDATED);
        /* === Call and asserts  === */
        $res = $this->obj->updateById($DATA, $ID);
        $this->assertEquals($UPDATED, $res);
    }

    public function test_updateById_string()
    {
        /* === Test Data === */
        $ID = 'simple';
        $DATA = [[1], [2]];
        $UPDATED = 'rows updated';
        /* === Setup Mocks === */
        // $val = is_int($id) ? $id : $this->_conn->quote($id);
        $this->mConn
            ->shouldReceive('quote')->once()
            ->andReturn("'$ID'");
        // $result = $this->_repoGeneric->updateEntity($this->_entityName, $data, $where);
        $this->mRepoGeneric
            ->shouldReceive('updateEntity')->once()
            ->with($this->ENTITY_NAME, $DATA, $this->PK_ATTR . "='$ID'")
            ->andReturn($UPDATED);
        /* === Call and asserts  === */
        $res = $this->obj->updateById($DATA, $ID);
        $this->assertEquals($UPDATED, $res);
    }

}

class TestEntity extends \Praxigento\Core\Data\Entity\Base
{
    const ATTR_ID = 'pkey';
    const ENTITY_NAME = 'test entity';

    public function getPrimaryKeyAttrs()
    {
        return [static::ATTR_ID];
    }

}
