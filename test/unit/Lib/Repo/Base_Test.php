<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase {
    /** @var  Base */
    private $repo;

    protected function setUp() {
        parent::setUp();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDba($mConn);
        $mRepoBasic = $this->_mockRepoBasic($mDba);
        $this->repo = new Base($mRepoBasic);
    }


    public function test_getBasicRepo() {
        $resp = $this->repo->getBasicRepo();
        $this->assertInstanceOf(\Praxigento\Core\Lib\Repo\IBasic::class, $resp);
    }
}