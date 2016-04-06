<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Request;


class GetEntities extends \Praxigento\Core\Service\Base\Request {
    /**
     * (string) Name of the entity to select (Account::ENTITY_NAME).
     */
    const ENTITY = 'entity';
    /**
     * (array|string) Fields names to select (if 'null' - all fields will be selected).
     */
    const FIELDS = 'fields';
    /**
     * Limit number of the items in the result set.
     * @var int
     */
    const LIMIT = 'limit';
    /**
     * @var array
     */
    const ORDER = 'order';
    /**
     * (array|string) WHERE clause for the selection.
     */
    const WHERE = 'where';

    /**
     * @param string       $entity
     * @param array|string $where
     * @param array|string $fields
     * @param null         $order
     * @param null         $limit
     */
    public function __construct($entity, $where = null, $fields = '*', $order = null, $limit = null) {
        $this->setData(self::ENTITY, $entity);
        $this->setData(self::WHERE, $where);
        $fieldsChecked = is_null($fields) ? '*' : $fields;
        $this->setData(self::FIELDS, $fieldsChecked);
        $this->setData(self::ORDER, $order);
        $this->setData(self::LIMIT, $limit);
    }
}