<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Response;


class AddEntity extends \Praxigento\Core\Service\Base\Response {
    const ID_INSERTED = 'latest_id';

    public function getIdInserted() {
        $result = $this->getData(self::ID_INSERTED);
        return $result;
    }

    public function setIdInserted($val) {
        $this->setData(self::ID_INSERTED, $val);
    }
}