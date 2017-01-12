<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Entity\Def;

use Praxigento\Core\Data\Entity\Type\Base as EntityTypeBase;

/**
 * Base implementation for types codifiers repository.
 */
abstract class Type
    extends \Praxigento\Core\Repo\Def\Entity
    implements \Praxigento\Core\Repo\Entity\IType
{
    /** @inheritdoc */
    public function getIdByCode($code)
    {
        $result = null;
        $where = EntityTypeBase::ATTR_CODE . '=' . $this->conn->quote($code);
        $data = $this->_repoGeneric->getEntities($this->_entityName, null, $where);
        if ($data) {
            $first = reset($data);
            $result = (int)$first[EntityTypeBase::ATTR_ID];
        }
        return $result;
    }

}