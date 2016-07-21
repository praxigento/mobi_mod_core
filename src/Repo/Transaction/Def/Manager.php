<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Transaction\Def;

use Praxigento\Core\Repo\Transaction\IDefinition;

class Manager
    extends \Flancer32\Lib\DataObject
    implements \Praxigento\Core\Repo\Transaction\IManager
{
    /**
     * Current Transaction Level
     *
     * @var int
     */
    protected $_transactionLevel = 0;
    /** @var \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $manObj;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\ObjectManagerInterface $manObj
    ) {
        $this->_conn = $resource->getConnection();
        $this->manObj = $manObj;
    }

    /**
     * @inheritdoc
     */
    public function transactionBegin()
    {
        $this->_transactionLevel++;
        $this->_conn->beginTransaction();
        $result = $this->manObj->create(IDefinition::class);
        $result->setLevel($this->_transactionLevel);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function transactionClose(IDefinition $data)
    {
        $level = $data->getLevel();
        $levelUp = $level - 1;
        if ($level == $this->_transactionLevel) {
            $this->_conn->rollBack();
            $this->_transactionLevel--;
        } elseif ($levelUp) {
            // do nothing, this is committed transaction
        } else {
            // exception should be thrown but I suppose it will be done in the other place.
        }
    }

    /**
     * @inheritdoc
     */
    public function transactionCommit(IDefinition $data)
    {
        $level = $data->getLevel();
        if ($level == $this->_transactionLevel) {
            $this->_conn->commit();
            $this->_transactionLevel--;
        }
    }

    /**
     * @inheritdoc
     */
    public function transactionRollback(IDefinition $data)
    {
        $level = $data->getLevel();
        if ($level == $this->_transactionLevel) {
            $this->_conn->rollBack();
            $this->_transactionLevel--;
        }
    }

}