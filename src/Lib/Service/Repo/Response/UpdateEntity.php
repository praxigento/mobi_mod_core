<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Response;


class UpdateEntity extends \Praxigento\Core\Lib\Service\Base\Response {
    const ROWS_UPDATED = 'rows_updated';

    public function  getRowsUpdated() {
        $result = $this->getData(self::ROWS_UPDATED);
        return $result;
    }
}