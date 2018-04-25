<?php
/**
 * Datetime processing tool.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Api\Helper;

/**
 * Use date/time related functions.
 *
 * TODO: perhaps these methods can be moved into .\Format interface.
 */
interface Date
{
    /**
     * Return 'Magento' now (according to locale settings).
     * @return \DateTime
     */
    public function getMageNow();

    /**
     * Return 'Magento' now (according to locale settings) formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS'
     */
    public function getMageNowForDb();

    /**
     * Return UTC now.
     *
     * @return \DateTime
     */
    public function getUtcNow();

    /**
     * Return UTC now formatted as DB timestamp.
     * @return string 'YYYY-MM-DD HH:MM:SS
     */
    public function getUtcNowForDb();
}