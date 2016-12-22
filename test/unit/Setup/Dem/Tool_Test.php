<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Setup\Dem;

use Praxigento\Core\Setup\Dem\Cfg as DemCfg;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Tool_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mSetup;
    /** @var  \Mockery\MockInterface */
    private $mContext;
    /** @var  \Mockery\MockInterface */
    private $mConn;
    /** @var  \Mockery\MockInterface */
    private $mResource;
    /** @var  \Mockery\MockInterface */
    private $mParser;
    /** @var  Tool */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = $this->_mockConn();
        $this->mResource = $this->_mockResourceConnection($this->mConn);
        $this->mParser = $this->_mock(\Praxigento\Core\Setup\Dem\Parser::class);
        $this->mSetup = $this->_mock(\Magento\Framework\Setup\SchemaSetupInterface::class);
        $this->mContext = $this->_mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        /** setup mocks for constructor */
        $this->mResource
            ->shouldReceive('getConnection')->once()
            ->andReturn($this->mConn);
        /** create object to test */
        $logger = $this->_mockLogger();
        $this->obj = new Tool($this->mResource, $logger, $this->mParser);
    }

    public function test_createEntity()
    {
        /** === Test Data === */
        $ENTITY = 'entity_alias';
        $TABLE = 'main table';
        $TABLE_FK = 'fk_table';
        $DEM = [
            DemCfg::COMMENT => 'comment',
            DemCfg::ATTRIBUTE => [
                'key' => [
                    DemCfg::ALIAS => 'alias',
                    DemCfg::TYPE => 'type'
                ]
            ],
            DemCfg::INDEX => [
                'pk' => [DemCfg::TYPE => DemType::INDEX_PRIMARY],
                'other' => [DemCfg::TYPE => DemType::INDEX_UNIQUE]
            ],
            DemCfg::RELATION => [
                [
                    DemCfg::OWN => [DemCfg::ALIASES => ['own_alias']],
                    DemCfg::REFERENCE => [
                        DemCfg::ENTITY => [DemCfg::COMPLETE_ALIAS => 'fk_tbl_alias'],
                        DemCfg::ALIASES => ['fk_col_alias']
                    ],
                    DemCfg::ACTION => [
                        DemCfg::DELETE => 'on delete'
                    ]
                ],
                /* this foreign key is not exist */
                [
                    DemCfg::OWN => [DemCfg::ALIASES => ['own_alias']],
                    DemCfg::REFERENCE => [
                        DemCfg::ENTITY => [DemCfg::COMPLETE_ALIAS => 'fk_tbl_alias_not_exist'],
                        DemCfg::ALIASES => ['fk_col_alias']
                    ],
                    DemCfg::ACTION => [
                        DemCfg::DELETE => 'on delete'
                    ]
                ]
            ]
        ];
        /** === Setup Mocks === */
        // $tblName = $this->_resource->getTableName($entityAlias);
        $this->mResource
            ->shouldReceive('getTableName')->once()
            ->with($ENTITY)
            ->andReturn($TABLE);
        // $tbl = $this->_conn->newTable($tblName);
        $mTbl = $this->_mock(\Magento\Framework\DB\Ddl\Table::class);
        $this->mConn
            ->shouldReceive('newTable')->once()
            ->andReturn($mTbl);
        // $tbl->setComment($demEntity[DemCfg::COMMENT]);
        $mTbl->shouldReceive('setComment')->once();
        // $attrType = $this->_parser->entityGetAttrType($attr[DemCfg::TYPE]);
        $this->mParser
            ->shouldReceive('entityGetAttrType')->once();
        // $attrSize = $this->_parser->entityGetAttrSize($attr[DemCfg::TYPE]);
        $this->mParser
            ->shouldReceive('entityGetAttrSize')->once();
        // $attrOpts = $this->_parser->entityGetAttrOptions($attr, $indexes);
        $this->mParser
            ->shouldReceive('entityGetAttrOptions')->once();
        // $tbl->addColumn($attrName, $attrType, $attrSize, $attrOpts, $attrComment);
        $mTbl->shouldReceive('addColumn')->once();
        // $ndxFields = $this->_parser->entityGetIndexFields($ndx);
        $this->mParser
            ->shouldReceive('entityGetIndexFields')->once();
        // $ndxType = $this->_parser->entityGetIndexType($ndx);
        $this->mParser
            ->shouldReceive('entityGetIndexType')->once();
        // $ndxOpts = $this->_parser->entityGetIndexOptions($ndx);
        $this->mParser
            ->shouldReceive('entityGetIndexOptions')->once();
        // $ndxName = $conn->getIndexName($entityAlias, $ndxFields, $ndxType);
        $this->mConn
            ->shouldReceive('getIndexName')->once();
        // $tbl->addIndex($ndxName, $ndxFields, $ndxOpts);
        $mTbl->shouldReceive('addIndex')->once();
        // $conn->createTable($tbl);
        $this->mConn
            ->shouldReceive('createTable')->once();
        //
        // REFERENCES (2 iterations)
        //
        // $refTable = $this->_resource->getTableName($refTableAlias);
        $this->mResource
            ->shouldReceive('getTableName')->twice()
            ->andReturn($TABLE_FK);
        // $onDelete = $this->_parser->referenceGetAction($one[DemCfg::ACTION][DemCfg::DELETE]);
        $this->mParser
            ->shouldReceive('referenceGetAction')->twice();
        // $fkName = $conn->getForeignKeyName($tblName, $ownColumn, $refTable, $refColumn);
        $this->mConn
            ->shouldReceive('getForeignKeyName')->twice();
        // $conn->addForeignKey($fkName, $tblName, $ownColumn, $refTable, $refColumn, $onDelete, $onUpdate);
        $this->mConn
            ->shouldReceive('addForeignKey')->once();
        // second iteration will throw exception
        $this->mConn
            ->shouldReceive('addForeignKey')->once()
            ->andThrow(new \Exception());
        /** === Call and asserts  === */
        $this->obj->createEntity($ENTITY, $DEM);
    }

    public function test_readDemPackage()
    {
        /** === Test Data === */
        $pathToFile = __DIR__ . '/data/dem.json';
        $pathToNode = '/path/to/node';
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $res = $this->obj->readDemPackage($pathToFile, $pathToNode);
        $this->assertEquals('DEM', $res->get('data'));
    }

    /**
     * @expectedException \Exception
     */
    public function test_readDemPackage_exception()
    {
        /** === Test Data === */
        $pathToFile = __DIR__ . '/data/dem.json';
        $pathToNode = '/no/path/to/node';
        /** === Setup Mocks === */
        /** === Call and asserts  === */
        $res = $this->obj->readDemPackage($pathToFile, $pathToNode);
        $this->assertEquals('DEM', $res->get('data'));
    }

}