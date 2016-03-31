<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Type\Base;

use Praxigento\Core\Lib\Entity\Type\Base as BaseTypeEntity;
use Praxigento\Core\Lib\Service\Type\Base\Request;
use Praxigento\Core\Lib\Service\Type\Base\Response;

abstract class Call extends \Praxigento\Core\Lib\Service\Base\Call implements \Praxigento\Core\Lib\Service\ITypeBase {

    /**
     * @return Response\GetByCode
     */
    protected abstract function _getResponse();

    /**
     * @return string
     */
    protected abstract function _getEntityName();

    /**
     * Get type data by code.
     *
     * @param Request\GetByCode $request
     *
     * @return Response\GetByCode
     */
    public function getByCode(Request\GetByCode $request) {
        $result = $this->_getResponse();
        $code = $request->getCode();
        $tbl = $this->_getTableName($this->_getEntityName());
        /** @var  $query \Zend_Db_Select */
        $query = $this->_getConn()->select();
        $query->from($tbl);
        $query->where(BaseTypeEntity::ATTR_CODE . '=:code');
        // $sql = (string)$query;
        $data = $this->_getConn()->fetchRow($query, [ 'code' => $code ]);
        if(is_array($data)) {
            $result->setData($data);
            $result->setErrorCode(Response\GetByCode::ERR_NO_ERROR);
        }
        return $result;
    }

}