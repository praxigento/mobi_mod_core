<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class Convert_UnitTest extends \Praxigento\Core\Test\BaseMockeryCase
{


    /** @var  Convert */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Convert();
    }

    public function test_toDateTime()
    {
        /** === Test Data === */
        $DATE = '2015-08-23 21:32:43';
        /** === Call and asserts  === */
        /* string */
        $dt = $this->obj->toDateTime($DATE);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
        /* int */
        $dt = $this->obj->toDateTime($dt->getTimestamp());
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
        /* \DateTime */
        $dt = $this->obj->toDateTime($dt);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($DATE, $dt->format(Cfg::FORMAT_DATETIME));
    }

    public function test_camelCaseToSnakeCase()
    {
        /** === Test Data === */
        $INPUT = 'CamelCase';
        $EXPECTED = 'camel_case';
        /** === Call and asserts  === */
        $res = $this->obj->camelCaseToSnakeCase($INPUT);
        $this->assertEquals($EXPECTED, $res);
    }
    public function test_snakeCaseToCamelCase()
    {
        /** === Test Data === */
        $INPUT = 'snake_case';
        $EXPECTED = 'snakeCase';
        /** === Call and asserts  === */
        $res = $this->obj->snakeCaseToCamelCase($INPUT);
        $this->assertEquals($EXPECTED, $res);
    }
    public function test_snakeCaseToUpperCamelCase()
    {
        /** === Test Data === */
        $INPUT = 'snake_case';
        $EXPECTED = 'SnakeCase';
        /** === Call and asserts  === */
        $res = $this->obj->snakeCaseToUpperCamelCase($INPUT);
        $this->assertEquals($EXPECTED, $res);
    }
}