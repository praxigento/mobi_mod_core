<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Data;


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
     * @return array
     */
    public function getPrimaryKeyAttrs();
}