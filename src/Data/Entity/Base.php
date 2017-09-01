<?php
/**
 * Base class for persistence entities (match to tables/views in DB).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data\Entity;

abstract class Base
    extends \Praxigento\Core\Data
    implements \Praxigento\Core\Data\IEntity
{
    /**
     * Name of the entity (table name w/o prefix). Should be overridden in child classes.
     */
    const ENTITY_NAME = '';

    /**
     * @return string
     */
    public static function getEntityName()
    {
        /* "static::" will use child attribute value (don't use 'self::') */
        return static::ENTITY_NAME;
    }
}