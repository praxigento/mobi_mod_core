<?php
/**
 * Tools related to operations with DEM (Domain Entities Map).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Setup\Dem;

use Praxigento\Core\App\Setup\Dem\Cfg as DemCfg;
use Praxigento\Core\Config;
use Praxigento\Core\Data as DataObject;

class Tool
{
    /** Path separator between packages. */
    const PS = Config::DEM_PS;
    /** @var \Psr\Log\LoggerInterface */
    private $_logger;
    /** @var \Praxigento\Core\App\Setup\Dem\Parser */
    private $_parser;
    /** @var \Magento\Framework\App\ResourceConnection */
    private $_resource;

    /**
     * Tool constructor.
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\App\Setup\Dem\Parser $parser
    ) {
        $this->_resource = $resource;
        $this->_conn = $resource->getConnection();
        $this->_logger = $logger;
        $this->_parser = $parser;
    }

    /**
     *
     * @param $entityAlias string Alias of the entity ('prxgt_acc_type_asset').
     * @param $demEntity array Associative array with entity definition (DEM subtree).
     */
    public function createEntity($entityAlias, $demEntity)
    {
        $tblName = $this->_resource->getTableName($entityAlias);
        $this->_logger->info("Create new table: $tblName.");
        /* init new object to create table in DB */
        $tbl = $this->_conn->newTable($tblName);
        if (isset($demEntity[DemCfg::COMMENT])) {
            $tbl->setComment($demEntity[DemCfg::COMMENT]);
        }
        $indexes = isset($demEntity[DemCfg::INDEX]) ? $demEntity[DemCfg::INDEX] : null;
        $relations = isset($demEntity[DemCfg::RELATION]) ? $demEntity[DemCfg::RELATION] : null;
        /* parse attributes */
        foreach ($demEntity[DemCfg::ATTRIBUTE] as $key => $attr) {
            $attrName = $attr[DemCfg::ALIAS];
            $attrType = $this->_parser->entityGetAttrType($attr[DemCfg::TYPE]);
            $attrSize = $this->_parser->entityGetAttrSize($attr[DemCfg::TYPE]);
            $attrOpts = $this->_parser->entityGetAttrOptions($attr, $indexes);
            $attrComment = isset($attr[DemCfg::COMMENT]) ? $attr[DemCfg::COMMENT] : null;
            $tbl->addColumn($attrName, $attrType, $attrSize, $attrOpts, $attrComment);
        }
        /* parse indexes */
        if ($indexes) {
            foreach ($indexes as $key => $ndx) {
                /* PRIMARY indexes are processed as columns options */
                if ($ndx[DemCfg::TYPE] == DemType::INDEX_PRIMARY) {
                    continue;
                }
                /* process not PRIMARY indexes */
                $ndxFields = $this->_parser->entityGetIndexFields($ndx);
                $ndxType = $this->_parser->entityGetIndexType($ndx);
                $ndxOpts = $this->_parser->entityGetIndexOptions($ndx);
                $ndxName = $this->_conn->getIndexName($entityAlias, $ndxFields, $ndxType);
                $this->_logger->info("Create new index: $ndxName.");
                $tbl->addIndex($ndxName, $ndxFields, $ndxOpts);
            }
        }
        /* create new table */
        $this->_conn->createTable($tbl);
        /* parse relations */
        if ($relations) {
            foreach ($relations as $one) {
                /* one only column FK is supported by Magento FW */
                $ownColumn = reset($one[DemCfg::OWN][DemCfg::ALIASES]);
                $refTableAlias = $one[DemCfg::REFERENCE][DemCfg::ENTITY][DemCfg::COMPLETE_ALIAS];
                $refTable = $this->_resource->getTableName($refTableAlias);
                $refColumn = reset($one[DemCfg::REFERENCE][DemCfg::ALIASES]);
                $onDelete = $this->_parser->referenceGetAction($one[DemCfg::ACTION][DemCfg::DELETE]);
                /* there is no onUpdate in M2, $purge is used instead. Set default value 'false' for purge. */
                //$onUpdate = $this->_parser->referenceGetAction($one[DemCfg::ACTION][DemCfg::UPDATE]);
                $onUpdate = false;
                $fkName = $this->_conn->getForeignKeyName($tblName, $ownColumn, $refTable, $refColumn);
                $this->_logger->info("Create new relation '$fkName' from '$tblName:$ownColumn' to '$refTable:$refColumn'.");
                try {
                    $this->_conn->addForeignKey($fkName, $tblName, $ownColumn, $refTable, $refColumn, $onDelete,
                        $onUpdate);
                } catch (\Exception $e) {
                    $msg = "Cannot create FK '$fkName'. Error: " . $e->getMessage();
                    $this->_logger->error($msg);
                }
            }
        }
    }

    /**
     * Read JSON file with DEM, extract and return DEM node as an associative array.
     *
     * @param string $pathToDemFile absolute path to the DEM definition in JSON format.
     * @param string $pathToDemNode as "/dBEAR/package/Praxigento/package/ExpDate"
     * @return DataObject
     * @throws \Exception
     */
    public function readDemPackage($pathToDemFile, $pathToDemNode)
    {
        $json = file_get_contents($pathToDemFile);
        $data = json_decode($json, true);
        $paths = explode(self::PS, $pathToDemNode);
        foreach ($paths as $path) {
            if (strlen(trim($path)) > 0) {
                if (isset($data[$path])) {
                    $data = $data[$path];
                } else {
                    throw new \Exception("Cannot find DEM node '$pathToDemNode' in file '$pathToDemFile'.");
                }
            }
        }
        $result = new DataObject($data);
        return $result;
    }
}