<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test;

use Mockery as m;


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

    protected function _mockConn()
    {
        $result = $this->_mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        return $result;
    }

    protected function _mockDbSelect()
    {
        $result = $this->_mock(\Magento\Framework\DB\Select::class);
        return $result;
    }

    /**
     * @deprecated use _mockConn() instead of.
     */
    protected function _mockDba()
    {
        return $this->_mockConn();
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockLogger()
    {
        $result = $this->_mock(\Psr\Log\LoggerInterface::class);
        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockObjectManager()
    {
        $result = $this->_mock(\Magento\Framework\ObjectManagerInterface::class);
        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockRepoGeneric()
    {
        $result = $this->_mock(\Praxigento\Core\Repo\IGeneric::class);
        return $result;
    }

    /**
     * @param $class
     * @param null $mRepoGeneric
     * @return m\MockInterface
     */
    protected function _mockRepoMod($class, $mRepoGeneric = null)
    {
        $result = $this->_mock($class);
        $result
            ->shouldReceive('getBasicRepo')
            ->andReturn($mRepoGeneric);
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

    /**
     * @return m\MockInterface
     */
    protected function _mockTransactionDefinition()
    {
        $result = $this->_mock(\Praxigento\Core\Repo\ITransactionDefinition::class);
        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockTransactionManager()
    {
        $result = $this->_mock(\Praxigento\Core\Repo\ITransactionManager::class);
        return $result;
    }
}