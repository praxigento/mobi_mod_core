<?php
/**
 * Datetime tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Lib\Context as Ctx;
use Praxigento\Core\Tool\IDate;
use Praxigento\Core\Tool\IFormat;

class Date implements IDate
{
    /** @var  IFormat */
    protected $_toolFormat;
    /**
     * Add delta to get Mage time from UTC time or subtract delta to get UTC time from Mage time.
     *
     * @var int Delta in seconds for Magento timezone according to UTC
     */
    protected $_tzDelta = 0;

    /**
     * @param IFormat $toolFormat
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    public function __construct(
        IFormat $toolFormat,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->_toolFormat = $toolFormat;
        $this->_tzDelta = $dateTime->getGmtOffset();
    }

    /**
     * Return 'Magento' now (according to locale settings).
     * @return \DateTime
     */
    public function getMageNow()
    {
        $dtUtc = $this->getUtcNow();
        $result = $dtUtc->setTimestamp($dtUtc->getTimestamp() + $this->_tzDelta);
        return $result;
    }

    /**
     * Return 'Magento' now (according to locale settings) formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS'
     */
    public function getMageNowForDb()
    {
        $dt = $this->getMageNow();
        $result = $this->_toolFormat->dateTimeForDb($dt);
        return $result;
    }

    /**
     * Return UTC now.
     *
     * @return \DateTime
     */
    public function getUtcNow()
    {
        $result = new \DateTime('now', new \DateTimeZone('UTC'));
        return $result;
    }

    /**
     * Return UTC now formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS
     */
    public function getUtcNowForDb()
    {
        $dt = $this->getUtcNow();
        $result = $this->_toolFormat->dateTimeForDb($dt);
        return $result;
    }
}