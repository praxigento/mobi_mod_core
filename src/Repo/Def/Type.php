<?php
/**
 * Base implementation for types codifiers repository.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\Entity\Type\Base as EntityTypeBase;
use Praxigento\Core\Repo\IType;

abstract class  Type extends Entity implements IType
{

    /** @inheritdoc */
    public function getIdByCode($code)
    {
        $result = null;
        $where = EntityTypeBase::ATTR_CODE . '=' . $this->_conn->quote($code);
        $data = $this->_repoGeneric->getEntities($this->_entityName, null, $where);
        if ($data) {
            $first = reset($data);
            $result = (int)$first[EntityTypeBase::ATTR_ID];
        }
        return $result;
    }

}