<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Service\Customer\Get\ById;

class Response
    extends \Praxigento\Core\Data
{
    const EMAIL = 'email';
    const ID = 'id';
    const NAME_FIRST = 'name_first';
    const NAME_LAST = 'name_last';

    /**
     * @return string|null
     */
    public function getEmail() {
        $result = parent::get(self::EMAIL);
        return $result;
    }

    /**
     * @return int|null
     */
    public function getId() {
        $result = parent::get(self::ID);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getNameFirst() {
        $result = parent::get(self::NAME_FIRST);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getNameLast() {
        $result = parent::get(self::NAME_LAST);
        return $result;
    }

    /**
     * @param string $data
     */
    public function setEmail($data) {
        parent::set(self::EMAIL, $data);
    }

    /**
     * @param int $data
     */
    public function setId($data) {
        parent::set(self::ID, $data);
    }

    /**
     * @param string $data
     */
    public function setNameFirst($data) {
        parent::set(self::NAME_FIRST, $data);
    }

    /**
     * @param string $data
     */
    public function setNameLast($data) {
        parent::set(self::NAME_LAST, $data);
    }

}