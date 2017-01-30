<?php
/**
 * Interface for the persistence entities (match to tables & vies in db).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data;


interface IEntity
{
    /**
     * Get name of the entity in DEM.
     *
     * @return string
     */
    public function getEntityName();

    /**
     * Get array with names of the primary key attributes.
     *
     * @return string[]
     */
    public function getPrimaryKeyAttrs();
}