<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo\Agg;

/**
 * Base class for factories to create SQL queries for aggregates.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
abstract class BaseSelectFactory
    implements \Praxigento\Core\App\Repo\Query\IHasSelect
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
}