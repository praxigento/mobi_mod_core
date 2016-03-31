<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Lib\Context;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Date_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {
    const OFFSET = 36000;

    public function test_constructor() {
        /** === Test Data === */
        /** === Mocks === */
        $mDt = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', [ 'getGmtOffset' ]);
        $mDt
            ->expects($this->once())
            ->method('getGmtOffset')
            ->willReturn(self::OFFSET);
        $mFrmt = $this->_mockFor('Praxigento\Core\Lib\Tool\Format');
        /** === Test itself === */
        /** @var  $obj Convert */
        $obj = new \Praxigento\Core\Lib\Tool\Date($mFrmt, $mDt);
        $this->assertNotNull($obj);
    }

    public function test_getUtcNow() {
        /** === Test Data === */
        /** === Mocks === */
        $mDt = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', [ 'getGmtOffset' ]);
        $mDt
            ->expects($this->once())
            ->method('getGmtOffset')
            ->willReturn(self::OFFSET);
        $mFrmt = $this->_mockFor('Praxigento\Core\Lib\Tool\Format');
        /** === Test itself === */
        /** @var  $obj Date */
        $obj = new \Praxigento\Core\Lib\Tool\Date($mFrmt, $mDt);
        $dt = $obj->getUtcNow();
        $this->assertInstanceOf(\DateTime::class, $dt);
    }

    public function test_getUtcNowForDb() {
        /** === Test Data === */
        $DB_TIMESTAMP = '2015-01-21 14:34:45';
        /** === Mocks === */
        $mDt = $this->_mockFor(\Magento\Framework\Stdlib\DateTime\DateTime::class, [ 'getGmtOffset' ]);
        $mDt
            ->expects($this->once())
            ->method('getGmtOffset')
            ->willReturn(self::OFFSET);
        $mFrmt = $this->_mockFor(\Praxigento\Core\Lib\Tool\Format::class);
        // $result = $this->_toolFormat->dateTimeForDb($dt);
        $mFrmt
            ->expects($this->once())
            ->method('dateTimeForDb')
            ->willReturn($DB_TIMESTAMP);
        /** === Test itself === */
        /** @var  $obj Date */
        $obj = new \Praxigento\Core\Lib\Tool\Date($mFrmt, $mDt);
        $ts = $obj->getUtcNowForDb();
        $this->assertEquals($DB_TIMESTAMP, $ts);
    }

    public function test_getMageNow() {
        /** === Test Data === */
        /** === Mocks === */
        $mDt = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', [ 'getGmtOffset' ]);
        $mDt
            ->expects($this->once())
            ->method('getGmtOffset')
            ->willReturn(self::OFFSET);
        $mFrmt = $this->_mockFor('Praxigento\Core\Lib\Tool\Format');
        /** === Test itself === */
        /** @var  $obj Date */
        $obj = new \Praxigento\Core\Lib\Tool\Date($mFrmt, $mDt);
        $dt = $obj->getMageNow();
        $this->assertInstanceOf(\DateTime::class, $dt);
    }

    public function test_getMageNowForDb() {
        /** === Test Data === */
        $DB_TIMESTAMP = '2015-01-21 14:34:45';
        /** === Mocks === */
        $mDt = $this->_mockFor('Magento\Framework\Stdlib\DateTime\DateTime', [ 'getGmtOffset' ]);
        $mDt
            ->expects($this->once())
            ->method('getGmtOffset')
            ->willReturn(self::OFFSET);
        $mFrmt = $this->_mockFor('Praxigento\Core\Lib\Tool\Format');
        // $result = $this->_toolFormat->dateTimeForDb($dt);
        $mFrmt
            ->expects($this->once())
            ->method('dateTimeForDb')
            ->willReturn($DB_TIMESTAMP);
        /** === Test itself === */
        /** @var  $obj Date */
        $obj = new \Praxigento\Core\Lib\Tool\Date($mFrmt, $mDt);
        $ts = $obj->getMageNowForDb();
        $this->assertEquals($DB_TIMESTAMP, $ts);
    }
}