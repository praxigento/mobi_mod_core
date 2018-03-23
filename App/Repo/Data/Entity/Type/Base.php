<?php
/**
 * Base class for types codifiers (id, code, note).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Data\Entity\Type;

abstract class Base
    extends \Praxigento\Core\App\Repo\Data\Entity\Base
{
    const A_CODE = 'code';
    const A_ID = 'id';
    const A_NOTE = 'note';

    /**
     * @return string
     */
    public function getCode()
    {
        $result = parent::get(self::A_CODE);
        return $result;
    }

    /**
     * @return int
     */
    public function getId()
    {
        $result = parent::get(self::A_ID);
        return $result;
    }

    /**
     * @return string|null
     */
    public function getNote()
    {
        $result = parent::get(self::A_NOTE);
        return $result;
    }

    public static function getPrimaryKeyAttrs()
    {
        return [self::A_ID];
    }

    /**
     * @param string $data
     */
    public function setCode($data)
    {
        parent::set(self::A_CODE, $data);
    }

    /**
     * @param int $data
     */
    public function setId($data)
    {
        parent::set(self::A_ID, $data);
    }

    /**
     * @param string $data
     */
    public function setNote($data)
    {
        parent::set(self::A_NOTE, $data);
    }
}