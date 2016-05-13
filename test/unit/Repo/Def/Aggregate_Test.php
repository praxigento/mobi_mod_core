<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Aggregate_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Aggregate */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoGeneric = $this->_mockRepoGeneric();
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTestAggregate($mResource);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\Def\Aggregate::class, $this->obj);
    }

    /**
     * @expectedException \Exception
     */
    public function test_create()
    {
        /** === Test Data === */
        $DATA = 'data';
        /** === Call and asserts  === */
        $this->obj->create($DATA);
    }

    /**
     * @expectedException \Exception
     */
    public function test_delete()
    {
        /** === Test Data === */
        $WHERE = 'data';
        /** === Call and asserts  === */
        $this->obj->delete($WHERE);
    }

    /**
     * @expectedException \Exception
     */
    public function test_deleteById()
    {
        /** === Test Data === */
        $ID = 'data';
        /** === Call and asserts  === */
        $this->obj->deleteById($ID);
    }

    /**
     * @expectedException \Exception
     */
    public function test_get()
    {
        /** === Test Data === */
        $WHERE = 'data';
        /** === Call and asserts  === */
        $this->obj->get($WHERE);
    }

    /**
     * @expectedException \Exception
     */
    public function test_updateById()
    {
        /** === Test Data === */
        $ID = 'id';
        $DATA = 'data';
        /** === Call and asserts  === */
        $this->obj->updateById($ID, $DATA);
    }
}

class ChildToTestAggregate extends Aggregate
{
    public function getById($id)
    {
        return 'value';
    }

    public function getQueryToSelect()
    {
        return 'value';
    }

    public function getQueryToSelectCount()
    {
        return 'value';
    }

}