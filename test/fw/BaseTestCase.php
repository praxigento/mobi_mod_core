<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Test;


use Praxigento\Core\Lib\Context;

abstract class BaseTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * Default mock for 'Praxigento\Core\Lib\Service\IRepo'.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockCallRepo() {
        $result = $this->_mockFor(\Praxigento\Core\Lib\Service\IRepo::class);
        return $result;
    }

    /**
     * Default mock for 'Magento\Framework\DB\Adapter\Pdo\Mysql'.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockConnection($methods = null) {
        if(is_null($methods)) {
            $methods = [
                'query', 'select', 'insert', 'insertArray', 'update', 'delete',
                'fetchRow', 'fetchOne', 'fetchAll',
                'beginTransaction', 'commit', 'rollBack',
                'quote', 'lastInsertId', 'getIndexName',
                'newTable', 'createTable', 'getForeignKeyName', 'addForeignKey', 'addColumn'
            ];
        }
        $result = $this->_mockFor(\Magento\Framework\DB\Adapter\Pdo\Mysql::class, $methods);
        return $result;
    }

    protected function _mockDbAdapter($mResource, $mConnection) {
        $result = $this
            ->getMockBuilder(\Praxigento\Core\Lib\Context\IDbAdapter::class)
            ->disableOriginalConstructor()
            ->setMethods([ 'getDefaultConnection', 'getResource', 'getTableName' ])
            ->getMock();
        $result
            ->expects($this->any())
            ->method('getDefaultConnection')
            ->willReturn($mConnection);
        $result
            ->expects($this->any())
            ->method('getResource')
            ->willReturn($mResource);
        return $result;
    }

    /**
     * Default mock for 'Zend_Db_Select'.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockDbSelect() {
        $result = $this->_mockFor(\Zend_Db_Select::class);
        return $result;
    }

    /**
     * Default mock for DEM DB initiator ('Praxigento\Core\Lib\Setup\Db').
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockDemSetupDb() {
        $result = $this->_mockFor(\Praxigento\Core\Lib\Setup\Db::class);
        return $result;
    }

    /**
     * Return default mock for the class or interface.
     *
     * @param  $name string distinguished name of the class or interface.
     * @param  $methods array  of the methods to be mocked or null.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockFor($name, $methods = null) {
        $builder = $this
            ->getMockBuilder($name)
            ->disableOriginalConstructor();
        if(!is_null($methods)) {
            $builder->setMethods($methods);
        }
        $result = $builder->getMock();
        return $result;
    }

    /**
     * Default mock for '\Psr\Log\LoggerInterface'.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockLogger() {
        $result = $this->_mockFor(\Psr\Log\LoggerInterface::class);
        return $result;
    }

    protected function _mockRepoBasic($mDba) {
        $result = $this
            ->getMockBuilder(\Praxigento\Core\Lib\Repo\IBasic::class)
            ->getMock();
        $result
            ->expects($this->any())
            ->method('getDba')
            ->willReturn($mDba);
        return $result;
    }

    /**
     * Default mock for 'Magento\Framework\App\ResourceConnection'.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _mockResource($methods = null) {
        if(is_null($methods)) {
            $methods = [
                'getConnection', 'getTableName'
            ];
        }
        $result = $this->_mockFor(\Magento\Framework\App\ResourceConnection::class, $methods);
        return $result;
    }

    protected function _mockToolbox(
        $mConvert = null,
        $mDate = null,
        $mFormat = null,
        $mPeriod = null
    ) {
        $result = $this->_mockFor(\Praxigento\Core\Lib\IToolbox::class);
        if(!is_null($mConvert)) {
            $result
                ->expects($this->any())
                ->method('getConvert')
                ->willReturn($mConvert);
        }
        if(!is_null($mDate)) {
            $result
                ->expects($this->any())
                ->method('getDate')
                ->willReturn($mDate);
        }
        if(!is_null($mFormat)) {
            $result
                ->expects($this->any())
                ->method('getFormat')
                ->willReturn($mFormat);
        }
        if(!is_null($mPeriod)) {
            $result
                ->expects($this->any())
                ->method('getPeriod')
                ->willReturn($mPeriod);
        }
        return $result;
    }

    /**
     * Use M1 Class Name Mapper to get appropriate mock.
     *
     * @param string $className
     *
     * @return \PHPUnit_Framework_MockObject_MockBuilder
     */
    public function getMockBuilder($className) {
        $mappedClassName = Context::getMappedClassName($className);
        return parent::getMockBuilder($mappedClassName);
    }
}