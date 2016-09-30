<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase\Repo\Agg;

use Mockery as m;

/**
 * Base class to create units to test factories for SQL Selects.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class SelectFactory
    extends \Praxigento\Core\Test\BaseCase\Repo
{
    /**
     * Create SQL renderer to be used in select object.
     *
     * @return \Magento\Framework\DB\Select\SelectRenderer
     */
    private function _createRenderer()
    {
        $quote = new \Magento\Framework\DB\Platform\Quote();
        $result = new \Magento\Framework\DB\Select\SelectRenderer(
            [
                'distinct' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\DistinctRenderer(),
                        'sort' => 100,
                        'part' => 'distinct'
                    ],
                'columns' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\ColumnsRenderer($quote),
                        'sort' => 200,
                        'part' => 'columns'
                    ],
                'union' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\UnionRenderer(),
                        'sort' => 300,
                        'part' => 'union'
                    ],
                'from' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\FromRenderer($quote),
                        'sort' => 400,
                        'part' => 'from'
                    ],
                'where' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\WhereRenderer(),
                        'sort' => 500,
                        'part' => 'where'
                    ],
                'group' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\GroupRenderer($quote),
                        'sort' => 600,
                        'part' => 'group'
                    ],
                'having' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\HavingRenderer(),
                        'sort' => 700,
                        'part' => 'having'
                    ],
                'order' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\OrderRenderer($quote),
                        'sort' => 800,
                        'part' => 'order'
                    ],
                'limit' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\LimitRenderer(),
                        'sort' => 900,
                        'part' => 'limitcount'
                    ],
                'for_update' =>
                    [
                        'renderer' => new \Magento\Framework\DB\Select\ForUpdateRenderer(),
                        'sort' => 1000,
                        'part' => 'forupdate'
                    ],
            ]
        );
        return $result;
    }

    /**
     * Create Select object (not fully mocked).
     *
     * @return \Magento\Framework\DB\Select
     */
    protected function _createSelect()
    {
        $mAdapter = $this->_mock(\Magento\Framework\DB\Adapter\Pdo\Mysql::class);
        $selectRenderer = $this->_createRenderer();
        $result = new \Magento\Framework\DB\Select($mAdapter, $selectRenderer);
        return $result;
    }

    /**
     * Initialise resource mock to handle 'getTableName' calls.
     *
     * @param array $names
     */
    protected function _setTableNames($names)
    {
        foreach ($names as $name) {
            $this->mResource
                ->shouldReceive('getTableName')->once()
                ->with($name)
                ->andReturn($name);
        }
    }

    protected function setUp()
    {
        parent::setUp();
        /* re-create select and bind it to connection */
        $select = $this->_createSelect();
        $this->mConn
            ->shouldReceive('select')
            ->andReturn($select);
    }
}