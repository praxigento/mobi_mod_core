<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Request;


class ReplaceEntity extends \Praxigento\Core\Lib\Service\Base\Request {
    /**
     * (string) Name of the entity to select (Account::ENTITY_NAME).
     */
    const ENTITY = 'entity';
    /**
     * Data to be inserted/updated: ['field' => 'value'].
     */
    const BIND = 'bind';

    /**
     * @param        $entity
     * @param array  $bind
     */
    public function __construct($entity, array $bind) {
        $this->setData(self::ENTITY, $entity);
        $this->setData(self::BIND, $bind);
    }
}