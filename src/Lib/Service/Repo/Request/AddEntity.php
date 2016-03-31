<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Request;


class AddEntity extends \Praxigento\Core\Lib\Service\Base\Request {
    /**
     * (string) Name of the entity to select (Account::ENTITY_NAME).
     */
    const ENTITY = 'entity';
    /**
     * Data to be inserted: ['field' => 'value'].
     */
    const BIND = 'bind';

    /**
     * @param string $entity Name of the entity to be added (Account::ENTITY_NAME).
     * @param array  $bind Data to be inserted: ['field' => 'value'].
     */
    public function __construct($entity = null, array $bind = [ ]) {
        $this->setData(self::ENTITY, $entity);
        $this->setData(self::BIND, $bind);
    }

    public function setEntity($entity) {
        $this->setData(self::ENTITY, $entity);
    }

    public function setBind($bind) {
        $this->setData(self::BIND, $bind);
    }
}