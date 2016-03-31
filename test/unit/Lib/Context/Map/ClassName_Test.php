<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Map;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class ClassName_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_all() {
        /** === Test Data === */
        $M1_CLASS = 'm1classname';
        $M2_CLASS = 'm2classname';
        /** === Mocks === */
        /** === Test itself === */
        $map = ClassName::getInstance();
        $this->assertEquals($M2_CLASS, $map->getM1Name($M2_CLASS));
        $map->merge([ $M2_CLASS => $M1_CLASS ]);
        $this->assertEquals($M1_CLASS, $map->getM1Name($M2_CLASS));
        $map->reset();
        $this->assertEquals($M2_CLASS, $map->getM1Name($M2_CLASS));
    }

}