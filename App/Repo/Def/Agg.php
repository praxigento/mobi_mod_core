<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo\Def;

/**
 * Default implementation for aggregate repository to do read-write operations with database.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
abstract class Agg
    extends Crud
{
    /** @var  \Praxigento\Core\App\Repo\Query\IHasSelect */
    protected $_factorySelect;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\App\Repo\Query\IHasSelect $factorySelect
    ) {
        parent::__construct($resource);
        $this->_factorySelect = $factorySelect;
    }


    public function getQueryToSelect()
    {
        $result = $this->_factorySelect->getQueryToSelect();
        return $result;
    }

    public function getQueryToSelectCount()
    {
        $result = $this->_factorySelect->getQueryToSelectCount();
        return $result;
    }

}