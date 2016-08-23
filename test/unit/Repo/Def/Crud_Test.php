<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class ChildToTestCrud extends Crud
{

}

class Crud_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Crud */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoGeneric = $this->_mockRepoGeneric();
        /** create object to test */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTestCrud($mResource);
    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(\Praxigento\Core\Repo\ICrud::class, $this->obj);
        $this->assertInstanceOf(\Praxigento\Core\Repo\IDataSource::class, $this->obj);
        $this->assertInstanceOf(\Praxigento\Core\Repo\Query\IHasSelect::class, $this->obj);
    }

    /** @expectedException \Exception */
    public function test_create()
    {
        /** === Call and asserts  === */
        $this->obj->create([]);
    }

    /** @expectedException \Exception */
    public function test_delete()
    {
        /** === Call and asserts  === */
        $this->obj->delete([]);
    }

    /** @expectedException \Exception */
    public function test_deleteById()
    {
        /** === Call and asserts  === */
        $this->obj->deleteById([]);
    }

    /** @expectedException \Exception */
    public function test_get()
    {
        /** === Call and asserts  === */
        $this->obj->get([]);
    }

    /** @expectedException \Exception */
    public function test_getById()
    {
        /** === Call and asserts  === */
        $this->obj->getById([]);
    }

    /** @expectedException \Exception */
    public function test_getQueryToSelect()
    {
        /** === Call and asserts  === */
        $this->obj->getQueryToSelect([]);
    }

    /** @expectedException \Exception */
    public function test_getQueryToSelectCount()
    {
        /** === Call and asserts  === */
        $this->obj->getQueryToSelectCount([]);
    }

    /** @expectedException \Exception */
    public function test_replace()
    {
        /** === Call and asserts  === */
        $this->obj->replace([]);
    }

    /** @expectedException \Exception */
    public function test_update()
    {
        /** === Call and asserts  === */
        $this->obj->update('data', 'where');
    }

    /** @expectedException \Exception */
    public function test_updateById()
    {
        /** === Call and asserts  === */
        $this->obj->updateById('id', 'data');
    }

}