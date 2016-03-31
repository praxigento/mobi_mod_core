<?php
/**
 * Parse DEM structures and return data to process in \Praxigento\Core\Lib\Setup\Db class.
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Setup\Db\Dem;

use Praxigento\Core\Lib\Setup\Db\Dem as Dem;
use Praxigento\Core\Lib\Setup\Db\Dem\Type as DemType;
use Praxigento\Core\Lib\Setup\Db\Mage\Type as MageType;

class Parser {
    /**
     * Parse DEM attribute and indexes data and return options for Magento DDL field.
     *
     * @param $demAttr
     * @param $demIndexes
     *
     * @return array
     */
    public function entityGetAttrOptions($demAttr, $demIndexes) {
        $result = [ ];
        $alias = $demAttr[Dem::ALIAS];
        /* parse common options */
        if(isset($demAttr[Dem::NULLABLE])) {
            $result[MageType::OPT_NULLABLE] = $demAttr[Dem::NULLABLE];
        }
        if(isset($demAttr[Dem::DEFAULT_])) {
            $result[MageType::OPT_DEFAULT] = $demAttr[Dem::DEFAULT_];
        }
        /* parse indexes to define PRIMARY option */
        foreach($demIndexes as $ndx) {
            $ndxType = $ndx[Dem::TYPE];
            if($ndxType == DemType::INDEX_PRIMARY) {
                foreach($ndx[Dem::ALIASES] as $one) {
                    if($alias == $one) {
                        $result[MageType::INDEX_PRIMARY] = true;
                        break;
                    }
                }
                break;
            }
        }
        /* parse type specific options */
        $type = key($demAttr[Dem::TYPE]);
        switch($type) {
            case DemType::ATTR_BINARY:
                break;
            case DemType::ATTR_BOOLEAN:
                break;
            case DemType::ATTR_DATETIME:
                if(isset($demAttr[Dem::DEFAULT_]) && ($demAttr[Dem::DEFAULT_] == DemType::DEF_CURRENT)) {
                    $result[MageType::OPT_DEFAULT] = MageType::DEF_CURRENT_TIMESTAMP;
                }
                break;
            case DemType::ATTR_INTEGER:
                if(isset($demAttr[Dem::TYPE][DemType::ATTR_INTEGER][Dem::UNSIGNED])) {
                    $result[MageType::OPT_UNSIGNED] = $demAttr[Dem::TYPE][DemType::ATTR_INTEGER][Dem::UNSIGNED];
                }
                if(isset($demAttr[Dem::TYPE][DemType::ATTR_INTEGER][Dem::AUTOINCREMENT])) {
                    $result[MageType::OPT_AUTO_INC] = $demAttr[Dem::TYPE][DemType::ATTR_INTEGER][Dem::AUTOINCREMENT];
                }
                break;
            case DemType::ATTR_NUMERIC:
                break;
            case DemType::ATTR_OPTION:
                break;
            case DemType::ATTR_TEXT:
                break;
        }
        return $result;
    }

    /**
     * Parse DEM attribute data and return size for Magento DDL field.
     *
     * @param $demAttrType
     *
     * @return null
     */
    public function entityGetAttrSize($demAttrType) {
        $result = null;
        $type = key($demAttrType);
        $typeData = reset($demAttrType);
        switch($type) {
            case DemType::ATTR_BINARY:
                break;
            case DemType::ATTR_BOOLEAN:
                break;
            case DemType::ATTR_DATETIME:
                break;
            case DemType::ATTR_INTEGER:
                $result = isset($typeData[Dem::LENGTH]) ? $typeData[Dem::LENGTH] : null;
                break;
            case DemType::ATTR_NUMERIC:
                if(isset($typeData[Dem::PRECISION])) {
                    /* we should have 2 elements in the result array*/
                    $result = [ MageType::OPT_PRECISION => 10, MageType::OPT_SCALE => 0 ];
                    $result[MageType::OPT_PRECISION] = $typeData[Dem::PRECISION];
                    if(isset($typeData[Dem::SCALE])) {
                        $result[MageType::OPT_SCALE] = $typeData[Dem::SCALE];
                    }
                }
                break;
            case DemType::ATTR_OPTION:
                break;
            case DemType::ATTR_TEXT:
                $result = isset($typeData[Dem::LENGTH]) ? $typeData[Dem::LENGTH] : null;
                break;
        }
        return $result;
    }

    /**
     * Parse DEM attribute data and return type for Magento DDL field.
     *
     * @param $demAttrType
     *
     * @return string
     */
    public function entityGetAttrType($demAttrType) {
        $result = MageType::COL_TEXT;
        $type = key($demAttrType);
        $typeData = reset($demAttrType);
        switch($type) {
            case DemType::ATTR_BINARY:
                $result = MageType::COL_BLOB;
                break;
            case DemType::ATTR_BOOLEAN:
                $result = MageType::COL_BOOLEAN;
                break;
            case DemType::ATTR_DATETIME:
                $result = MageType::COL_TIMESTAMP;
                break;
            case DemType::ATTR_INTEGER:
                $result = MageType::COL_INTEGER;
                if(isset($typeData[Dem::SUBTYPE])) {
                    if($typeData[Dem::SUBTYPE] == DemType::ATTRSUB_SMALL_INT) {
                        $result = MageType::COL_SMALLINT;
                    }
                }
                break;
            case DemType::ATTR_NUMERIC:
                $result = MageType::COL_DECIMAL;
                break;
            case DemType::ATTR_OPTION:
                $result = MageType::COL_TEXT;
                break;
            case DemType::ATTR_TEXT:
                $result = MageType::COL_TEXT;
                break;
        }
        return $result;
    }

    public function entityGetIndexFields($demIndex) {
        $result = $demIndex[Dem::ALIASES];
        return $result;
    }

    public function entityGetIndexOptions($demIndex) {
        $result = [ ];
        if(
            isset($demIndex[Dem::TYPE]) &&
            ($demIndex[Dem::TYPE] == DemType::INDEX_UNIQUE)
        ) {
            $result[MageType::OPT_TYPE] = MageType::INDEX_UNIQUE;
        }
        return $result;
    }

    public function entityGetIndexType($demIndex) {
        $result = MageType::INDEX_INDEX;
        if(isset($demIndex[Dem::TYPE])) {
            $type = $demIndex[Dem::TYPE];
            switch($type) {
                case DemType::INDEX_PRIMARY:
                    $result = MageType::INDEX_PRIMARY;
                    break;
                case DemType::INDEX_UNIQUE:
                    $result = MageType::INDEX_UNIQUE;
                    break;
                case DemType::INDEX_TEXT:
                    $result = MageType::INDEX_FULLTEXT;
                    break;
            }
        }
        return $result;
    }

    /**
     * Map DEM foreign keys actions to Varien values.
     *
     * @param $demAction
     *
     * @return string
     */
    public function referenceGetAction($demAction) {
        $result = MageType::REF_ACTION_NO_ACTION;
        if($demAction == DemType::REF_ACTION_RESTRICT) {
            $result = MageType::REF_ACTION_RESTRICT;
        } else {
            if($demAction == DemType::REF_ACTION_CASCADE) {
                $result = MageType::REF_ACTION_CASCADE;
            }
        }
        return $result;
    }
}