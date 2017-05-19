<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query;

/**
 * Base class for query builders (new format).
 */
abstract class Builder
    implements \Praxigento\Core\Repo\Query\IBuilder2
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

    public function getResource()
    {
        return $this->resource;
    }
}