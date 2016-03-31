<?php
/**
 * Toolbox to get base implementation of tools from \Praxigento\Core\Lib\Tool package.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Lib\IToolbox;

class Box implements IToolbox {
    /** @var Convert */
    private $_convert;
    /** @var Date */
    private $_date;
    /** @var Format */
    private $_format;
    /** @var Period */
    private $_period;

    /**
     * Toolbox constructor.
     */
    public function __construct(
        Convert $convert,
        Date $date,
        Format $format,
        Period $period
    ) {
        $this->_convert = $convert;
        $this->_date = $date;
        $this->_format = $format;
        $this->_period = $period;
    }

    /**
     * @return Convert
     */
    public function getConvert() {
        return $this->_convert;
    }

    /**
     * @return Date
     */
    public function getDate() {
        return $this->_date;
    }

    /**
     * @return Format
     */
    public function getFormat() {
        return $this->_format;
    }

    /**
     * @return Period
     */
    public function getPeriod() {
        return $this->_period;
    }


}