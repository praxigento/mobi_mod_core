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
    protected $conn;
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
        $this->conn = $resource->getConnection();
    }

    public function getConnection($name = null)
    {
        if (is_null($name)) {
            $name = \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION;
        }
        $result = $this->resource->getConnection($name);
        return $result;
    }

    public function getResource()
    {
        return $this->resource;
    }
}