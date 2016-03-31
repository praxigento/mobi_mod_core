<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup\Db;

use Praxigento\Core\Config;
use Praxigento\Core\Lib\Context;
use Praxigento\Core\Lib\Setup\Db\Dem as Dem;
use Praxigento\Core\Lib\Setup\Db\Dem\Parser;
use Praxigento\Core\Lib\Setup\Db\Dem\Type as DemType;
use Praxigento\Core\Lib\Setup\Db\Mage\Type as MageType;


include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Parser_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {
    const ALIAS = 'alias';
    const DEFAULT_VALUE = 'default value';

    public function test_entityGetAttrOptions_binary() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_BINARY);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrOptions_boolean() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_BOOLEAN);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrOptions_datetime() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_DATETIME);
        $demAttr[Dem::DEFAULT_] = DemType::DEF_CURRENT;
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrOptions_integer() {
        /** === Test Data === */
        $opts = [ Dem::UNSIGNED => true, Dem::AUTOINCREMENT => true ];
        $demAttr = $this->_getDemAttr(DemType::ATTR_INTEGER, $opts);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(5, count($resp));
    }

    public function test_entityGetAttrOptions_numeric() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_NUMERIC);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrOptions_option() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_OPTION);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrOptions_text() {
        /** === Test Data === */
        $demAttr = $this->_getDemAttr(DemType::ATTR_TEXT);
        $demIndexes = $this->_getDemIndexes();
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrOptions($demAttr, $demIndexes);
        $this->assertTrue(is_array($resp));
        $this->assertEquals(3, count($resp));
    }

    public function test_entityGetAttrSize_binary() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_BINARY => [ ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNull($resp);
    }

    public function test_entityGetAttrSize_boolean() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_BOOLEAN => [ ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNull($resp);
    }

    public function test_entityGetAttrSize_datetime() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_DATETIME => [ ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNull($resp);
    }

    public function test_entityGetAttrSize_integer() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_INTEGER => [ ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNull($resp);
    }

    public function test_entityGetAttrSize_numeric() {
        /** === Test Data === */
        $demAttrType = [
            DemType::ATTR_NUMERIC => [
                Dem::PRECISION => 8,
                Dem::SCALE     => 2
            ]
        ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNotNull($resp);
        $this->assertArrayHasKey('precision', $resp);
        $this->assertArrayHasKey('scale', $resp);
    }

    public function test_entityGetAttrSize_option() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_OPTION => [ ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertNull($resp);
    }

    public function test_entityGetAttrSize_text() {
        /** === Test Data === */
        $demAttrType = [ DemType::ATTR_TEXT => [ Dem::LENGTH => 8 ] ];
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetAttrSize($demAttrType);
        $this->assertEquals(8, $resp);
    }

    public function test_entityGetAttrType_all() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $type = $obj->entityGetAttrType([ DemType::ATTR_BINARY => [ ] ]);
        $this->assertEquals(MageType::COL_BLOB, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_BOOLEAN => [ ] ]);
        $this->assertEquals(MageType::COL_BOOLEAN, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_DATETIME => [ ] ]);
        $this->assertEquals(MageType::COL_TIMESTAMP, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_INTEGER => [ ] ]);
        $this->assertEquals(MageType::COL_INTEGER, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_NUMERIC => [ ] ]);
        $this->assertEquals(MageType::COL_DECIMAL, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_OPTION => [ ] ]);
        $this->assertEquals(MageType::COL_TEXT, $type);
        $type = $obj->entityGetAttrType([ DemType::ATTR_TEXT => [ ] ]);
        $this->assertEquals(MageType::COL_TEXT, $type);
    }

    public function test_entityGetIndexOptions() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $opts = $obj->entityGetIndexOptions([ Dem::TYPE => DemType::INDEX_UNIQUE ]);
        $this->assertArrayHasKey(MageType::OPT_TYPE, $opts);

    }

    public function test_entityGetIndexFields() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->entityGetIndexFields([ Dem::ALIASES => self::ALIAS ]);
        $this->assertEquals(self::ALIAS, $resp);
    }

    public function test_entityGetIndexType_all() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $type = $obj->entityGetIndexType(null);
        $this->assertEquals(MageType::INDEX_INDEX, $type);
        $type = $obj->entityGetIndexType([ Dem::TYPE => DemType::INDEX_PRIMARY ]);
        $this->assertEquals(MageType::INDEX_PRIMARY, $type);
        $type = $obj->entityGetIndexType([ Dem::TYPE => DemType::INDEX_UNIQUE ]);
        $this->assertEquals(MageType::INDEX_UNIQUE, $type);
        $type = $obj->entityGetIndexType([ Dem::TYPE => DemType::INDEX_TEXT ]);
        $this->assertEquals(MageType::INDEX_FULLTEXT, $type);

    }

    public function test_referenceGetAction_all() {
        /** === Test Data === */
        /** === Mocks === */
        /** === Test itself === */
        $obj = new Parser();
        $resp = $obj->referenceGetAction(null);
        $this->assertEquals(MageType::REF_ACTION_NO_ACTION, $resp);
        $resp = $obj->referenceGetAction(DemType::REF_ACTION_RESTRICT);
        $this->assertEquals(MageType::REF_ACTION_RESTRICT, $resp);
        $resp = $obj->referenceGetAction(DemType::REF_ACTION_CASCADE);
        $this->assertEquals(MageType::REF_ACTION_CASCADE, $resp);
    }


    private function _getDemAttr($typeName = DemType::ATTR_TEXT, $typeOpts = [ ]) {
        $result = [
            Dem::ALIAS    => self::ALIAS,
            Dem::NULLABLE => true,
            Dem::DEFAULT_ => self::DEFAULT_VALUE,
            Dem::TYPE     => [ $typeName => $typeOpts ]
        ];
        return $result;
    }

    private function _getDemIndexes() {
        $result = [
            [
                Dem::TYPE    => DemType::INDEX_PRIMARY,
                Dem::ALIASES => [ self::ALIAS ]
            ]
        ];
        return $result;
    }
}