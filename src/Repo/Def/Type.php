<?php
/**
 * Base implementation for types codifiers repository.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Praxigento\Core\Data\Entity\Type\Base as EntityTypeBase;
use Praxigento\Core\Repo\IType;

abstract class  Type extends Base implements IType
{
    /**
     * Get name of the typed entity.
     * @return string
     */
    protected abstract function _getEntityName();

    /**
     * @inheritdoc
     */
    public function getIdByCode($code)
    {
        $result = null;
        $entity = $this->_getEntityName();
        $tbl = $this->_dba->getTableName($entity);
        /** @var  $query \Zend_Db_Select */
        $query = $this->_dba->select();
        $query->from($tbl);
        $query->where(EntityTypeBase::ATTR_CODE . '=:code');
        $data = $this->_dba->fetchRow($query, ['code' => $code]);
        if (
            is_array($data) &&
            isset($data[EntityTypeBase::ATTR_ID])
        ) {
            $result = (int)$data[EntityTypeBase::ATTR_ID];
        }
        return $result;
    }

}