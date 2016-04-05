<?php
/**
 * Base class for repositories implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

abstract class Base
{
    /** @var \Magento\Framework\App\ResourceConnection */
    protected $_resource;
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
        $this->_conn = $resource->getConnection();
    }

}