<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Transaction;

/**
 * Default implementation for Transaction items factory used by Database Transaction Manager.
 */
class Factory
    implements \Praxigento\Core\App\Api\Repo\Transaction\Factory
{
    /** @var \Magento\Framework\App\DeploymentConfig */
    private $configDeployment;
    /** @var \Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactoryInterface */
    private $factoryConn;
    /** @var \Magento\Framework\ObjectManagerInterface */
    private $manObj;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $maObj,
        \Magento\Framework\App\DeploymentConfig $configDeployment,
        \Magento\Framework\Model\ResourceModel\Type\Db\ConnectionFactory $factoryConn
    ) {
        $this->manObj = $maObj;
        $this->configDeployment = $configDeployment;
        $this->factoryConn = $factoryConn;
    }

    public function create($transactionName, $connectionName)
    {
        /** @var \Praxigento\Core\App\Repo\Transaction\Item $result */
        $result = $this->manObj->create(\Praxigento\Core\App\Repo\Transaction\Item::class);
        $result->setTransactionName($transactionName);
        $result->setConnectionName($connectionName);
        if (
            ($transactionName != \Praxigento\Core\App\Api\Repo\Transaction\Manager::DEF_TRANSACTION) ||
            ($connectionName != \Praxigento\Core\App\Api\Repo\Transaction\Manager::DEF_CONNECTION)
        ) {
            /* create new connection, don't use default connection/transaction */
            /* 'db/connection/default' */
            $cfgName =
                \Magento\Framework\Config\ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTIONS
                . '/' . $connectionName;
            /* {'host'=>'', 'dbname'=>'', 'username'=>'', 'password'=>'', 'model'=>'', 'engine'=>'', 'initStatements'=>'', 'active'=>''}*/
            $cfgData = $this->configDeployment->get($cfgName);
            /* @var \Magento\Framework\DB\Adapter\AdapterInterface $dba */
            $conn = $this->factoryConn->create($cfgData);
            $result->setConnection($conn);
        }
        return $result;
    }

}