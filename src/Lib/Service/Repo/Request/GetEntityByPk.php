<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Request;


class GetEntityByPk extends \Praxigento\Core\Lib\Service\Base\Request {
    /**
     * (string) Name of the entity to select (Account::ENTITY_NAME).
     */
    const ENTITY = 'entity';
    /**
     * (array|string) Fields names to select (if 'null' - all fields will be selected).
     */
    const FIELDS = 'fields';
    /**
     * (array) PK fields names and values to compose WHERE clause: ['id' => 21].
     */
    const PK = 'pk';

    /**
     * GetEntityByPk constructor.
     *
     * @param string       $entity
     * @param array|string $fields
     * @param array        $pk
     */
    public function __construct($entity, array $pk, $fields = '*') {
        $this->setData(self::ENTITY, $entity);
        $this->setData(self::PK, $pk);
        $this->setData(self::FIELDS, $fields);
    }
}