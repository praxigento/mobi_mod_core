<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Entity;

/**
 * Interface for type codifier repository.
 */
interface IType
    extends \Praxigento\Core\Repo\IEntity
{
    /**
     * @param string $code
     * @return int|null
     */
    public function getIdByCode($code);

}