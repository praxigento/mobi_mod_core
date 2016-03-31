<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Service\Repo\Request;

/**
 * @method array getBind() Data to be updated: ['field' => 'value'].
 * @method void setBind(array $data)
 * @method string getEntity() Name of the entity to select (Account::ENTITY_NAME).
 * @method void setEntity(string $data)
 * @method mixed getWhere() WHERE clause for the selection (string or array, see '$where' in \Zend_Db_Adapter_Abstract::update).
 * @method void setWhere(mixed $data)
 */
class UpdateEntity extends \Praxigento\Core\Lib\Service\Base\Request {

    /**
     * UpdateEntity constructor.
     *
     * @param        $entity
     * @param array  $bind
     * @param string $where
     */
    public function __construct($entity = null, array $bind = [ ], $where = '') {
        $this->setEntity($entity);
        $this->setBind($bind);
        $this->setWhere($where);
    }
}