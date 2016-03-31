<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;

use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Setup\Db\Dem as Dem;
use Praxigento\Core\Lib\Setup\Db\Dem\Type as DemType;
use Praxigento\Core\Lib\Setup\Db\Mage\Type as MageType;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Db_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_createEntity() {
        /** === Test Data === */
        $ENTITY_ALIAS = 'entity_alias';
        $REF_ENTITY_ALIAS = 'referenced_alias';
        $REF_ATTR_ALIAS = 'referenced_attr';
        $ATTR_ALIAS = 'attr_alias';
        $ATTR_NAME = 'attr_name';
        $TABLE = 'entity_table';
        $TABLE2 = 'ref_entity_table';
        $COMMENT = 'some comment is \'here\'.';
        $DEM_ENTITY = [
            Dem::COMMENT   => $COMMENT,
            Dem::ATTRIBUTE => [
                $ATTR_ALIAS => [
                    Dem::ALIAS => $ATTR_NAME,
                    Dem::TYPE  => [ ]
                ]
            ],
            Dem::INDEX     => [
                'primary' => [ Dem::TYPE => DemType::INDEX_PRIMARY, Dem::ALIASES => [ $ATTR_ALIAS ] ],
                'unique'  => [ Dem::TYPE => DemType::INDEX_UNIQUE, Dem::ALIASES => [ $ATTR_ALIAS ] ]
            ],
            Dem::RELATION  => [
                'someRelation' => [
                    Dem::OWN       => [ Dem::ALIASES => [ $ATTR_ALIAS ] ],
                    Dem::REFERENCE => [
                        Dem::ENTITY  => [ Dem::COMPLETE_ALIAS => $REF_ENTITY_ALIAS ],
                        Dem::ALIASES => [ $REF_ATTR_ALIAS ]
                    ],
                    Dem::ACTION    => [
                        Dem::DELETE => DemType::REF_ACTION_RESTRICT,
                        Dem::UPDATE => DemType::REF_ACTION_RESTRICT
                    ]
                ]
            ]
        ];
        /** === Mocks === */
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);
        $mParser = $this->_mockFor('Praxigento\Core\Lib\Setup\Db\Dem\Parser');

        // $tblName = $this->_resource->getTableName($entityAlias);
        $mDba
            ->expects($this->at(1))
            ->method('getTableName')
            ->willReturn($TABLE);
        // $tbl = $conn->newTable($tblName);
        $mTbl = $this->_mockFor(
            'Magento\Framework\DB\Ddl\Table',
            [ 'setComment', 'addColumn', 'addIndex' ]
        );
        $mConn
            ->expects($this->once())
            ->method('newTable')
            ->with($TABLE)
            ->willReturn($mTbl);
        // $attrType = $this->_parser->entityGetAttrType($attr[Dem::TYPE]);
        $mParser
            ->expects($this->once())
            ->method('entityGetAttrType')
            ->willReturn(MageType::COL_TEXT);
        // $attrSize = $this->_parser->entityGetAttrSize($attr[Dem::TYPE]);
        $mParser
            ->expects($this->once())
            ->method('entityGetAttrSize')
            ->willReturn(null);
        // $attrOpts = $this->_parser->entityGetAttrOptions($attr, $indexes);
        $mParser
            ->expects($this->once())
            ->method('entityGetAttrOptions')
            ->willReturn([ ]);
        // $tbl->addColumn($attrName, $attrType, $attrSize, $attrOpts, $attrComment);
        $mTbl
            ->expects($this->once())
            ->method('addColumn');
        // $tbl->addIndex($ndxName, $ndxFields, $ndxOpts);
        $mTbl
            ->expects($this->once())
            ->method('addIndex');
        //  $conn->createTable($tbl);
        $mConn
            ->expects($this->once())
            ->method('createTable');
        // $refTable = $this->_resource->getTableName($refTableAlias);
        $mDba
            ->expects($this->at(2))
            ->method('getTableName')
            ->willReturn($TABLE2);
        /** === Test itself === */
        $obj = new Db($mDba, $mParser);
        $obj->createEntity($ENTITY_ALIAS, $DEM_ENTITY);
    }

    public function test_createEntity_M2() {
        /** === Test Data === */
        $ENTITY_ALIAS = 'entity_alias';
        $REF_ENTITY_ALIAS = 'referenced_alias';
        $REF_ATTR_ALIAS = 'referenced_attr';
        $ATTR_ALIAS = 'attr_alias';
        $ATTR_NAME = 'attr_name';
        $TABLE = 'entity_table';
        $TABLE2 = 'ref_entity_table';
        $DEM_ENTITY = [
            Dem::ATTRIBUTE => [
                $ATTR_ALIAS => [
                    Dem::ALIAS => $ATTR_NAME,
                    Dem::TYPE  => [ ]
                ]
            ],
            Dem::INDEX     => [
                'primary' => [ Dem::TYPE => DemType::INDEX_PRIMARY, Dem::ALIASES => [ $ATTR_ALIAS ] ],
                'unique'  => [ Dem::TYPE => DemType::INDEX_UNIQUE, Dem::ALIASES => [ $ATTR_ALIAS ] ]
            ],
            Dem::RELATION  => [
                'someRelation' => [
                    Dem::OWN       => [ Dem::ALIASES => [ $ATTR_ALIAS ] ],
                    Dem::REFERENCE => [
                        Dem::ENTITY  => [ Dem::COMPLETE_ALIAS => $REF_ENTITY_ALIAS ],
                        Dem::ALIASES => [ $REF_ATTR_ALIAS ]
                    ],
                    Dem::ACTION    => [
                        Dem::DELETE => DemType::REF_ACTION_RESTRICT,
                        Dem::UPDATE => DemType::REF_ACTION_RESTRICT
                    ]
                ]
            ]
        ];
        /** === Mocks === */
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);
        $mParser = $this->_mockFor('Praxigento\Core\Lib\Setup\Db\Dem\Parser');

        // $tblName = $this->_resource->getTableName($entityAlias);
        $mDba
            ->expects($this->at(1))
            ->method('getTableName')
            ->willReturn($TABLE);
        // $tbl = $conn->newTable($tblName);
        $mTbl = $this->_mockFor(
            'Magento\Framework\DB\Ddl\Table',
            [ 'addColumn', 'addIndex' ]
        );
        $mConn
            ->expects($this->once())
            ->method('newTable')
            ->with($TABLE)
            ->willReturn($mTbl);
        //  $conn->createTable($tbl);
        $mConn
            ->expects($this->once())
            ->method('createTable');
        // $refTable = $this->_resource->getTableName($refTableAlias);
        $mDba
            ->expects($this->at(2))
            ->method('getTableName')
            ->willReturn($TABLE2);
        // if(Context::instance()->isMage2()) {...}
        $mCtx = $this->_mockFor('Praxigento\Core\Lib\Context');
        $mCtx
            ->expects($this->any())
            ->method('isMage2')
            ->willReturn(true);
        Context::set($mCtx);
        /** === Test itself === */
        $obj = new Db($mDba, $mParser);
        $obj->createEntity($ENTITY_ALIAS, $DEM_ENTITY);
        Context::reset();
    }
}