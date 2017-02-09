<?php
/**
 * Datetime tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Tool\Def;

use Praxigento\Core\Tool\IDate;
use Praxigento\Core\Tool\IFormat;

class Date implements IDate
{
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $manObj;
    /** @var  IFormat */
    protected $toolFormat;
    /**
     * Add delta to get Mage time from UTC time or subtract delta to get UTC time from Mage time.
     *
     * @var int Delta in seconds for Magento timezone according to UTC
     */
    protected $tzDelta;

    /**
     * @param IFormat $toolFormat
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        IFormat $toolFormat
    ) {
        $this->manObj = $manObj;
        $this->toolFormat = $toolFormat;
    }


    /**
     * MOBI-504: don't retrieve session depended objects from Object Manager
     *
     * @return \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private function _getTzDelta()
    {
        if (is_null($this->tzDelta)) {
            $this->tzDelta = $this->manObj->get(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        }
        return $this->tzDelta;
    }

    /**
     * Return 'Magento' now (according to locale settings).
     * @return \DateTime
     */
    public function getMageNow()
    {
        $dtUtc = $this->getUtcNow();
        $delta = $this->_getTzDelta();
        $tsUtc = $dtUtc->getTimestamp();
        $tsDelta = $delta->getGmtOffset();
        $result = $dtUtc->setTimestamp($tsUtc + $tsDelta);
        return $result;
    }

    /**
     * Return 'Magento' now (according to locale settings) formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS'
     */
    public function getMageNowForDb()
    {
        $dt = $this->getMageNow();
        $result = $this->toolFormat->dateTimeForDb($dt);
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
        $result = $this->toolFormat->dateTimeForDb($dt);
        return $result;
    }
}