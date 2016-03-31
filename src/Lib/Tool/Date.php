<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Tool;

use Praxigento\Core\Lib\Context as Ctx;

/**
 * Datetime processing tool.
 *
 * @package Praxigento\Core\Lib\Tool
 */
class Date {
    /** @var  Format */
    private $_toolFormat;
    /**
     * Add delta to get Mage time from UTC time or subtract delta to get UTC time from Mage time.
     *
     * @var int Delta in seconds for Magento timezone according to UTC
     */
    private $_tzDelta = 0;

    /**
     * @param \Mage_Core_Model_Date|\Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param Format                                                            $toolFormat
     */
    public function __construct(
        Format $toolFormat,
        $dateTime = null
    ) {
        $this->_toolFormat = $toolFormat;
        // @codeCoverageIgnoreStart
        if(is_null($dateTime)) {
            /** @var  $obm */
            $obm = Ctx::instance()->getObjectManager();
            if(class_exists('\Magento\Framework\Stdlib\DateTime\DateTime')) {
                $dt = $obm->get('\Magento\Framework\Stdlib\DateTime\DateTime');
                $this->_tzDelta = $dt->getGmtOffset();
            } else {
                $dt = $obm->get('\Mage_Core_Model_Date');
                $this->_tzDelta = $dt->getGmtOffset();
            }
        } else {
            $this->_tzDelta = $dateTime->getGmtOffset();
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Return UTC now.
     *
     * @return \DateTime
     */
    public function getUtcNow() {
        $result = new \DateTime('now', new \DateTimeZone('UTC'));
        return $result;
    }

    /**
     * Return UTC now formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS
     */
    public function getUtcNowForDb() {
        $dt = $this->getUtcNow();
        $result = $this->_toolFormat->dateTimeForDb($dt);
        return $result;
    }

    /**
     * Return 'Magento' now (according to locale settings).
     * @return \DateTime
     */
    public function getMageNow() {
        $dtUtc = $this->getUtcNow();
        $result = $dtUtc->setTimestamp($dtUtc->getTimestamp() + $this->_tzDelta);
        return $result;
    }

    /**
     * Return 'Magento' now (according to locale settings) formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS'
     */
    public function getMageNowForDb() {
        $dt = $this->getMageNow();
        $result = $this->_toolFormat->dateTimeForDb($dt);
        return $result;
    }
}