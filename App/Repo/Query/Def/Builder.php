<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Query\Def;

/**
 * Base class for query builders.
 *
 * @deprecated use \Praxigento\Core\App\Repo\Query\Builder
 */
abstract class Builder
    implements \Praxigento\Core\App\Repo\Query\IBuilder
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $conn; // default connection

    /** @var \Magento\Framework\App\ResourceConnection */
    protected $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->resource = $resource;
        $this->conn = $resource->getConnection();
    }

    public function build(\Magento\Framework\DB\Select $source = null)
    {
        throw new \Exception('Implement it if you need this method.');
    }

    public function getConnection($name = null)
    {
        $result = $this->resource->getConnection($name);
        return $result;
    }

    public function getResource()
    {
        return $this->resource;
    }
}