<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Date_UnitTest extends \Praxigento\Core\Lib\Test\BaseMockeryCase
{
    const OFFSET = 36000;
    /** @var  \Mockery\MockInterface */
    private $mDt;
    /** @var  \Mockery\MockInterface */
    private $mFormat;
    /** @var  Date */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->mFormat = $this->_mock(\Praxigento\Core\Tool\IFormat::class);
        $this->mDt = $this->_mock(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        $this->mDt
            ->shouldReceive('getGmtOffset')
            ->andReturn(self::OFFSET);
        $this->obj = new Date(
            $this->mFormat,
            $this->mDt
        );
    }


    public function test_getMageNow()
    {
        /* === Call and asserts  === */
        $dt = $this->obj->getMageNow();
        $this->assertInstanceOf(\DateTime::class, $dt);
    }

    public function test_getMageNowForDb()
    {
        /* === Test Data === */
        $DB_TIMESTAMP = '2015-01-21 14:34:45';
        /* === Setup Mocks === */
        $this->mFormat
            ->shouldReceive('dateTimeForDb')->once()
            ->andReturn($DB_TIMESTAMP);
        /* === Call and asserts  === */
        $ts = $this->obj->getMageNowForDb();
        $this->assertEquals($DB_TIMESTAMP, $ts);
    }

    public function test_getUtcNow()
    {
        /* === Call and asserts  === */
        $dt = $this->obj->getUtcNow();
        $this->assertInstanceOf(\DateTime::class, $dt);
    }

    public function test_getUtcNowForDb()
    {
        /* === Test Data === */
        $DB_TIMESTAMP = '2015-01-21 14:34:45';
        /* === Setup Mocks === */
        $this->mFormat
            ->shouldReceive('dateTimeForDb')->once()
            ->andReturn($DB_TIMESTAMP);
        /* === Call and asserts  === */
        $ts = $this->obj->getUtcNowForDb();
        $this->assertEquals($DB_TIMESTAMP, $ts);
    }
}