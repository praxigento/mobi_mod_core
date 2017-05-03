<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query\Def;

/**
 * Base class for query builders.
 */
abstract class Builder
    implements \Praxigento\Core\Repo\Query\IBuilder
{
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $conn; // default connection

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
        $result = $this->resource->getConnection($name);
        return $result;
    }

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Will throw an error if is not overridden.
     *
     * @inheritdoc
     */
    public function getCountQuery(\Praxigento\Core\Repo\Query\IBuilder $qbuild = null)
    {
        throw new \Exception('Implement if you need this query.');
    }

    /**
     * Will throw an error if is not overridden.
     *
     * @inheritdoc
     */
    public function getSelectQuery(\Praxigento\Core\Repo\Query\IBuilder $qbuild = null)
    {
        throw new \Exception('Implement if you need this query.');
    }
}