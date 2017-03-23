<?php
/**
 * Base class for persistence entities (match to tables/views in DB).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data\Entity;

abstract class Base
    extends \Flancer32\Lib\Data
    implements \Praxigento\Core\Data\IEntity
{
    /**
     * @return string
     */
    public function getEntityName()
    {
        return static::ENTITY_NAME; // "static::" will use child attribute value
    }
}