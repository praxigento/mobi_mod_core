<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Dao;

use Praxigento\Core\App\Repo\Data\Entity\Type\Base as EntityTypeBase;

/**
 * Base implementation for types codifiers repository.
 */
abstract class Type
    extends \Praxigento\Core\App\Repo\Dao
{
    /**
     * @param string $code
     * @return int|null
     */
    public function getIdByCode($code)
    {
        $result = null;
        $where = EntityTypeBase::A_CODE . '=' . $this->conn->quote($code);
        $data = $this->daoGeneric->getEntities($this->entityName, null, $where);
        if ($data) {
            $first = reset($data);
            $result = (int)$first[EntityTypeBase::A_ID];
        }
        return $result;
    }

}