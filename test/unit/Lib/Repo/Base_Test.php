<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Repo;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @deprecated
 */
class Base_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    /** @var  Base */
    private $repo;

    protected function setUp()
    {
        parent::setUp();
        $this->markTestSkipped('Test is deprecated after M1 & M2 merge is done.');
        $mConn = $this->_mockDba();
        $mDba = $this->_mockRsrcConnOld($mConn);
        $mRepoBasic = $this->_mockRepoBasic($mDba);
        $this->repo = new Base($mRepoBasic);
    }


    public function test_getBasicRepo()
    {
        $resp = $this->repo->getBasicRepo();
        $this->assertInstanceOf(\Praxigento\Core\Repo\IBasic::class, $resp);
    }
}