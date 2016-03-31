<?php
/**
 * Base class to create database schema in MOBI common modules.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Setup\Schema;


abstract class Base implements \Praxigento\Core\Lib\Setup\ISchema {
    /**
     * Separator in path to JSON node (dBEAR/package/Praxigento/package/Pv)
     */
    const PS = '/';
    /**
     * Utility to parse DEM JSON and to create DB structure.
     *
     * @var  \Praxigento\Core\Lib\Setup\Db
     */
    protected $_demDb;
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Praxigento\Core\Lib\Setup\Db $demDb
    ) {
        $this->_logger = $logger;
        $this->_demDb = $demDb;
    }

    /**
     * Read JSON file with DEM, extract and return DEM node as an associative array.
     *
     * @param $pathToFile
     * @param $pathToDemNode
     *
     * @return array
     */
    protected function _readDemPackage($pathToFile, $pathToDemNode) {
        $json = file_get_contents($pathToFile);
        $result = json_decode($json, true);
        $paths = explode(self::PS, $pathToDemNode);
        foreach($paths as $path) {
            if(strlen(trim($path)) > 0) {
                if(isset($result[$path])) {
                    $result = $result[$path];
                } else {
                    $result = [ ];
                    $this->_logger->error("Cannot find DEM node '$pathToDemNode' in file '$pathToFile'.");
                    break;
                }
            }
        }
        return $result;
    }
}