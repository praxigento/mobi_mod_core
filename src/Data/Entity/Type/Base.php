<?php
/**
 * Base class for types codifiers (id, code, note).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data\Entity\Type;

use Praxigento\Core\Data\Entity\Base as EntityBase;

abstract class Base extends EntityBase
{
    const ATTR_CODE = 'code';
    const ATTR_ID = 'id';
    const ATTR_NOTE = 'note';

    /**
     * @return string
     */
    public function getCode()
    {
        $result = parent::getData(self::ATTR_CODE);
        return $result;
    }

    /**
     * @return int
     */
    public function getId()
    {
        $result = parent::getData(self::ATTR_ID);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getNote()
    {
        $result = parent::getData(self::ATTR_NOTE);
        return $result;
    }

    public function getPrimaryKeyAttrs()
    {
        return [self::ATTR_ID];
    }

    /**
     * @param string $data
     */
    public function setCode($data)
    {
        parent::setData(self::ATTR_CODE, $data);
    }

    /**
     * @param int $data
     */
    public function setId($data)
    {
        parent::setData(self::ATTR_ID, $data);
    }

    /**
     * @param string $data
     */
    public function setNote($data)
    {
        parent::setData(self::ATTR_NOTE, $data);
    }
}