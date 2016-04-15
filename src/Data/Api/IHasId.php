<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data\Api;


interface  IHasId
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $data
     */
    public function setId($data);
}