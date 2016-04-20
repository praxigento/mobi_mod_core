<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\Entity\Type\Base as EntityTypeBase;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class ChildToTestType extends Type
{
    const ENTITY = 'entity';

    protected function _getEntityName()
    {
        return self::ENTITY;
    }

}

class Type_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  ChildToTestType */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoGeneric = $this->_mockRepoGeneric();
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTestType($mResource);
    }

    public function test_getIdByCode()
    {
        /* === Test Data === */
        $CODE = 'code';
        $ID = 43;
        $TABLE = 'table';
        /* === Setup Mocks === */
        // $tbl = $this->_conn->getTableName($entity);
        $this->mConn
            ->shouldReceive('getTableName')->once()
            ->with(ChildToTestType::ENTITY)
            ->andReturn($TABLE);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $this->mConn
            ->shouldReceive('select')->once()
            ->andReturn($mQuery);
        // $query->from($tbl);
        $mQuery->shouldReceive('from')->once();
        // $query->where(EntityTypeBase::ATTR_CODE . '=:code');
        $mQuery->shouldReceive('where')->once();
        // $data = $this->_conn->fetchRow($query, ['code' => $code]);
        $this->mConn
            ->shouldReceive('fetchRow')->once()
            ->andReturn($mQuery)
            ->andReturn([EntityTypeBase::ATTR_ID => $ID]);
        /* === Call and asserts  === */
        $res = $this->obj->getIdByCode($CODE);
        $this->assertEquals($ID, $res);
    }

}