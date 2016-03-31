<?php
/**
 * Map M2 class names to M1 class names if mapping should be done. Two types of the resolving exists:
 * - permanent: configured in the xml-files (see /prxgt/di/... nodes);
 * - dynamic: resolved by class names according to M2 & M1 namespaces;
 *
 * For the time only permanent type is used.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Context\Map;


class ClassName {

    /** @var  ClassName */
    private static $_instance;
    /**
     * @var array Registry for replacements ([interface => implementation, m2class => m1class, ...])
     */
    private $_map = [ ];

    public static function getInstance() {
        if(!self::$_instance instanceof ClassName) {
            self::$_instance = new ClassName();
        }
        return self::$_instance;
    }

    public function getM1Name($m2name) {
        $result = trim($m2name);
        if(isset($this->_map[$result])) {
            $result = $this->_map[$result];
        }
        return $result;
    }

    /**
     * Remove all entries from the class names map.
     */
    public function merge($entries) {
        $this->_map = array_merge($this->_map, $entries);
    }

    /**
     * Remove all entries from the class names map.
     */
    public function reset() {
        $this->_map = [ ];
    }
}