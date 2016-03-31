<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib;


/**
 * Toolbox interface to get tools from \Praxigento\Core\Lib\Tool package.
 *
 * @package Praxigento\Core\Lib
 */
interface IToolbox {
    /**
     * @return Tool\Convert
     */
    public function getConvert();

    /**
     * @return Tool\Date
     */
    public function getDate();

    /**
     * @return Tool\Format
     */
    public function getFormat();

    /**
     * @return Tool\Period
     */
    public function getPeriod();
}