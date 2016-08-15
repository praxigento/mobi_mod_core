<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Transaction\Database\Def;

/**
 * Default implementation for Transaction items factory used by Database Transaction Manager.
 */
class Factory
    implements \Praxigento\Core\Transaction\Database\IFactory
{
    /** @var \Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactoryInterface */
    private $_factoryConn;
    /** @var \Magento\Framework\App\DeploymentConfig */
    private $_configDeployment;
    /** @var \Magento\Framework\ObjectManagerInterface */
    private $_manObj;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $maObj,
        \Magento\Framework\App\DeploymentConfig $configDeployment,
        \Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactory $factoryConn
    ) {
        $this->_manObj = $maObj;
        $this->_configDeployment = $configDeployment;
        $this->_factoryConn = $factoryConn;
    }

    /** @inheritdoc */
    public function create($transactionName, $connectionName)
    {
        /** @var \Praxigento\Core\Transaction\Database\Def\Item $result */
        $result = $this->_manObj->create(\Praxigento\Core\Transaction\Database\Def\Item::class);
        $result->setTransactionName($transactionName);
        $result->setConnectionName($connectionName);
        if (
            ($transactionName != \Praxigento\Core\Transaction\Database\IManager::DEF_TRANSACTION) ||
            ($connectionName != \Praxigento\Core\Transaction\Database\IManager::DEF_CONNECTION)
        ) {
            /* create new connection, don't use default connection/transaction */
            /* 'db/connection/default' */
            $cfgName =
                \Magento\Framework\Config\ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTIONS
                . '/' . $connectionName;
            /* {'host'=>'', 'dbname'=>'', 'username'=>'', 'password'=>'', 'model'=>'', 'engine'=>'', 'initStatements'=>'', 'active'=>''}*/
            $cfgData = $this->_configDeployment->get($cfgName);
            /* @var \Magento\Framework\DB\Adapter\AdapterInterface $dba */
            $conn = $this->_factoryConn->create($cfgData);
            $result->setConnection($conn);
        }
        return $result;
    }

}