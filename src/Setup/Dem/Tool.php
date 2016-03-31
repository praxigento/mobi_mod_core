<?php
/**
 * Tools related to operations with DEM (Domain Entities Map).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Setup\Dem;

use Praxigento\Core\Config as Cfg;

class Tool
{
    const PS = Cfg::DEM_PS;

    /**
     * Read JSON file with DEM, extract and return DEM node as an associative array.
     *
     * @param string $pathToDemFile absolute path to the DEM definition in JSON format.
     * @param string $pathToDemNode as "/dBEAR/package/Praxigento/package/ExpDate"
     * @return array
     * @throws \Exception
     */
    public function readDemPackage($pathToDemFile, $pathToDemNode)
    {
        $json = file_get_contents($pathToDemFile);
        $result = json_decode($json, true);
        $paths = explode(self::PS, $pathToDemNode);
        foreach ($paths as $path) {
            if (strlen(trim($path)) > 0) {
                if (isset($result[$path])) {
                    $result = $result[$path];
                } else {
                    throw new \Exception("Cannot find DEM node '$pathToDemNode' in file '$pathToDemFile'.");
                }
            }
        }
        return $result;
    }
}