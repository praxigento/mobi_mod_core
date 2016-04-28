<?php
/**
 * Interface for types codifiers repository.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;


interface IType extends IEntity
{
    /**
     * @param string $code
     * @return int|null
     */
    public function getIdByCode($code);

}