<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

/**
 * Base class for DB repositories implementations.
 */
abstract class Db
    implements \Praxigento\Core\Repo\IDb
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
        $this->_conn = $resource->getConnection();
    }

    public function getConnection($name = null)
    {
        if (is_null($name)) {
            $name = \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION;
        }
        $result = $this->_resource->getConnection($name);
        return $result;
    }

    public function getResource()
    {
        return $this->_resource;
    }
}