<?php
/**
 * Interface for the persistence entities (match to tables & vies in db).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\App\Repo\Data;


interface Entity
{
    /**
     * Get name of the entity (table name w/o prefix).
     *
     * @return string
     */
    public static function getEntityName();

    /**
     * Get array with names of the primary key attributes.
     *
     * @return string[]
     */
    public static function getPrimaryKeyAttrs();
}