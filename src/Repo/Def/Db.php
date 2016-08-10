<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

/**
 * Base class for DB repositories implementations.
 */
abstract class Db
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

    /**
     * Retrieve connection to resource specified by $name
     *
     * @param string $name
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection($name = null)
    {
        if (is_null($name)) {
            $name = \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION;
        }
        $result = $this->_resource->getConnection($name);
        return $result;
    }
}