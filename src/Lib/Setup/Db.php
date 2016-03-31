<?php
/**
 * Utility to parse DEM JSON and to create DB structure.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup;

use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Setup\Db\Dem as Dem;
use Praxigento\Core\Lib\Setup\Db\Dem\Type as DemType;

class Db {
    /**
     * @var Db\Dem\Parser
     */
    private $_parser;
    /** @var  \Praxigento\Core\Lib\Context\IDbAdapter */
    protected $_dba;

    public function __construct(
        \Praxigento\Core\Lib\Context\IDbAdapter $dba,
        \Praxigento\Core\Lib\Setup\Db\Dem\Parser $parser
    ) {
        $this->_dba = $dba;
        $this->_parser = $parser;
    }
    protected function _getConn() {
        return $this->_dba->getDefaultConnection();
    }

    protected function _getTableName($entityName) {
        $result = $this->_dba->getTableName($entityName);
        return $result;
    }
    /**
     *
     * @param $entityAlias string Alias of the entity ('prxgt_acc_type_asset').
     * @param $demEntity array Associative array with entity definition (DEM subtree).
     */
    public function createEntity($entityAlias, $demEntity) {
        $conn = $this->_getConn();
        $tblName = $this->_getTableName($entityAlias);
        /* init new object to create table in DB */
        $tbl = $conn->newTable($tblName);
        if(isset($demEntity[Dem::COMMENT])) {
            $tbl->setComment($demEntity[Dem::COMMENT]);
        }
        $indexes = isset($demEntity[Dem::INDEX]) ? $demEntity[Dem::INDEX] : null;
        $relations = isset($demEntity[Dem::RELATION]) ? $demEntity[Dem::RELATION] : null;
        /* parse attributes */
        foreach($demEntity[Dem::ATTRIBUTE] as $key => $attr) {
            $attrName = $attr[Dem::ALIAS];
            $attrType = $this->_parser->entityGetAttrType($attr[Dem::TYPE]);
            $attrSize = $this->_parser->entityGetAttrSize($attr[Dem::TYPE]);
            $attrOpts = $this->_parser->entityGetAttrOptions($attr, $indexes);
            $attrComment = isset($attr[Dem::COMMENT]) ? $attr[Dem::COMMENT] : null;
            $tbl->addColumn($attrName, $attrType, $attrSize, $attrOpts, $attrComment);
        }
        /* parse indexes */
        if($indexes) {
            foreach($indexes as $key => $ndx) {
                /* PRIMARY indexes are processed as columns options */
                if($ndx[Dem::TYPE] == DemType::INDEX_PRIMARY) {
                    continue;
                }
                /* process not PRIMARY indexes */
                $ndxFields = $this->_parser->entityGetIndexFields($ndx);
                $ndxType = $this->_parser->entityGetIndexType($ndx);
                $ndxOpts = $this->_parser->entityGetIndexOptions($ndx);
                $ndxName = $conn->getIndexName($entityAlias, $ndxFields, $ndxType);
                $tbl->addIndex($ndxName, $ndxFields, $ndxOpts);
            }
        }
        /* create new table */
        $conn->createTable($tbl);
        /* parse relations */
        if($relations) {
            foreach($relations as $one) {
                /* one only column FK is supported by Magento FW */
                $ownColumn = reset($one[Dem::OWN][Dem::ALIASES]);
                $refTableAlias = $one[Dem::REFERENCE][Dem::ENTITY][Dem::COMPLETE_ALIAS];
                /* we need to map M2 names to M1 names */
                $refTableAlias = Context::getMappedEntityName($refTableAlias);
                $refTable = $this->_getTableName($refTableAlias);
                $refColumn = reset($one[Dem::REFERENCE][Dem::ALIASES]);
                $onDelete = $this->_parser->referenceGetAction($one[Dem::ACTION][Dem::DELETE]);
                $onUpdate = $this->_parser->referenceGetAction($one[Dem::ACTION][Dem::UPDATE]);
                $fkName = $conn->getForeignKeyName($tblName, $ownColumn, $refTable, $refColumn);
                if(Context::instance()->isMage2()) {
                    /* there is no onUpdate in M2, $purge is used instead. Set default value 'false' for purge. */
                    $onUpdate = false;
                }
                $conn->addForeignKey($fkName, $tblName, $ownColumn, $refTable, $refColumn, $onDelete, $onUpdate);
            }
        }
    }

}