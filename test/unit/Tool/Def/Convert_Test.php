<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Config as Cfg;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

/**
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Convert_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Mockery
{

    /** @var  Convert */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Convert();
    }

    public function test_camelCaseToSnakeCase()
    {
        /** === Test Data === */
        $input = 'CamelCase';
        $expected = 'camel_case';
        /** === Call and asserts  === */
        $res = $this->obj->camelCaseToSnakeCase($input);
        $this->assertEquals($expected, $res);
    }

    public function test_snakeCaseToCamelCase()
    {
        /** === Test Data === */
        $input = 'snake_case';
        $expected = 'snakeCase';
        /** === Call and asserts  === */
        $res = $this->obj->snakeCaseToCamelCase($input);
        $this->assertEquals($expected, $res);
    }

    public function test_snakeCaseToUpperCamelCase()
    {
        /** === Test Data === */
        $input = 'snake_case';
        $expected = 'SnakeCase';
        /** === Call and asserts  === */
        $res = $this->obj->snakeCaseToUpperCamelCase($input);
        $this->assertEquals($expected, $res);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function test_toDateTime()
    {
        /** === Test Data === */
        $date = '2015-08-23 21:32:43';
        /** === Call and asserts  === */
        /* string */
        $dt = $this->obj->toDateTime($date);
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($date, $dt->format(Cfg::FORMAT_DATETIME));
        /* int */
        $dt = $this->obj->toDateTime($dt->getTimestamp());
        $this->assertTrue($dt instanceof \DateTime);
        $this->assertEquals($date, $dt->format(Cfg::FORMAT_DATETIME));
        /* \DateTime */
        $dt = $this->obj->toDateTime(new \DateTime());
        $this->assertTrue($dt instanceof \DateTime);
    }
}