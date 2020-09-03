<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test\BaseCase;

use Mockery as m;

abstract class Mockery
    extends \PHPUnit\Framework\TestCase
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

    /**
     * Mock database connection (\Magento\Framework\DB\Adapter\AdapterInterface).
     * TODO: delete _populateMock() from the method
     *
     * @param array $mockedMethods
     * @return m\MockInterface
     */
    protected function _mockConn($mockedMethods = [])
    {
        $result = $this->_mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        $result = $this->_populateMock($result, $mockedMethods);
        return $result;
    }

    protected function _mockDbSelect($mockedMethods = [])
    {
        $result = $this->_mock(\Magento\Framework\DB\Select::class, null);
        $result = $this->_populateMock($result, $mockedMethods);
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
     * @param $withAllMethods
     * @return m\MockInterface
     */
    protected function _mockLogger($withAllMethods = true)
    {
        $result = $this->_mock(\Psr\Log\LoggerInterface::class);
        if ($withAllMethods) {
            $result->shouldReceive('alert', 'critical', 'debug', 'emergency', 'error', 'info', 'log', 'notice',
                'warning');
        }
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
        $result = $this->_mock(\Praxigento\Core\Api\App\Repo\Generic::class);
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

    protected function _mockResourceConnection($mConn = null)
    {
        $result = m::mock(\Magento\Framework\App\ResourceConnection::class);
        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockTransactionDefinition()
    {
        $result = $this->_mock(\Praxigento\Core\Api\App\Repo\Transaction\Definition::class);
        return $result;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * @return m\MockInterface
     */
    protected function _mockTransactionManager()
    {
        $result = $this->_mock(\Praxigento\Core\Api\App\Repo\Transaction\Manager::class);
        return $result;
    }

    private function _populateMock($mock, $methods)
    {
        if (
            is_array($methods) &&
            count($methods)
        ) {
            foreach ($methods as $method) {
                $mock->shouldReceive($method);
            }
        }
        return $mock;
    }
}
