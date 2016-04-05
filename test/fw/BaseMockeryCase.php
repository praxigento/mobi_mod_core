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
     * Get mock for the class/interface.
     *
     * @param  $className string distinguished name of the class or interface.
     *
     * @return \Mockery\MockInterface
     */
    protected function _mock($className)
    {
        $result = m::mock($className);
        return $result;
    }

    protected function _mockDbSelect()
    {
        $result = $this->_mock(\Magento\Framework\DB\Select::class);
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

    protected function _mockRepoBasic()
    {
        $result = $this->_mock(\Praxigento\Core\Repo\IBasic::class);
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

    protected function _mockResourceConnection($mDba)
    {
        $result = $this->_mock(\Magento\Framework\App\ResourceConnection::class);
        $result
            ->shouldReceive('getConnection')
            ->andReturn($mDba);
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