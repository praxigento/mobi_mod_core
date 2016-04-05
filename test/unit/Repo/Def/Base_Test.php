<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  Base */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mRepoBasic = $this->_mockRepoBasic();
        /* create object */
        $mResource = $this->_mockResourceConnection($this->mConn);
        $this->obj = new ChildToTest($mResource);
    }

    public function test_constructor()
    {
        /* === Test Data === */
        /* === Setup Mocks === */
        /* === Call and asserts  === */
        $this->assertTrue($this->obj instanceof \Praxigento\Core\Repo\Def\Base);
    }

}

class ChildToTest extends Base
{

}