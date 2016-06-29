<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo;

/**
 * Interface for types codifiers repository.
 *
 * TODO: move interface to ...\Entity\IType namespace
 */

interface IType extends IEntity
{
    /**
     * @param string $code
     * @return int|null
     */
    public function getIdByCode($code);

}