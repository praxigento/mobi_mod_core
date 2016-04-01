<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Test;

use Mockery as m;
use Praxigento\Core\Lib\Context;

abstract class BaseMockeryCase extends \PHPUnit_Framework_TestCase
{

    /**
     * Check name of the class or interface, convert M2 classes to M1 if necessary and return mock for valid name.
     *
     * @param  $className string distinguished name of the class or interface.
     *
     * @return \Mockery\MockInterface
     */
    protected function _mock($className)
    {
        $validClassName = Context::getMappedClassName($className);
        $result = m::mock($validClassName);
        return $result;
    }

    protected function _mockDbSelect()
    {
        $result = $this->_mock(\Praxigento\Core\Lib\Context\Dba\ISelect::class);
        return $result;
    }

    protected function _mockDba()
    {
        $result = $this->_mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        return $result;
    }

    protected function _mockLogger()
    {
        $result = $this->_mock(\Psr\Log\LoggerInterface::class);
        return $result;
    }

    protected function _mockRepoBasic($mDba)
    {
        $result = $this->_mock(\Praxigento\Core\Lib\Repo\IBasic::class);
        $result
            ->shouldReceive('getDba')
            ->andReturn($mDba);
        return $result;
    }

    protected function _mockRepoMod($class, $mRepoBasic = null)
    {
        $result = $this->_mock($class);
        $result
            ->shouldReceive('getBasicRepo')
            ->andReturn($mRepoBasic);
        return $result;
    }

    protected function _mockResourceConnection($mConn)
    {
        $result = $this->_mock(\Magento\Framework\App\ResourceConnection::class);
        $result
            ->shouldReceive('getConnection')
            ->andReturn($mConn);
        return $result;
    }

    protected function _mockRsrcConnOld($mConnection)
    {
        $result = $this->_mock(\Praxigento\Core\Lib\Context\IDbAdapter::class);
        $result
            ->shouldReceive('getDefaultConnection')
            ->andReturn($mConnection);
        return $result;
    }
}