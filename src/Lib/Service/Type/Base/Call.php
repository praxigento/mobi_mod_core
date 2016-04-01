<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Type\Base;

use Praxigento\Core\Data\Entity\Type\Base as BaseTypeEntity;
use Praxigento\Core\Lib\Repo\IBasic;
use Praxigento\Core\Lib\Service\Base\Call as BaseCall;
use Praxigento\Core\Lib\Service\ITypeBase;
use Praxigento\Core\Lib\Service\Type\Base\Request;
use Praxigento\Core\Lib\Service\Type\Base\Response;
use Psr\Log\LoggerInterface;

abstract class Call extends BaseCall implements ITypeBase
{
    /** @var  IBasic */
    protected $_repoBasic;

    public function __construct(
        LoggerInterface $logger,
        IBasic $repoBasic
    ) {
        parent::__construct($logger);
        $this->_repoBasic = $repoBasic;
    }

    /**
     * @return string
     */
    protected abstract function _getEntityName();

    /**
     * @return Response\GetByCode
     */
    protected abstract function _getResponse();

    /**
     * Get type data by code.
     *
     * @param Request\GetByCode $request
     *
     * @return Response\GetByCode
     */
    public function getByCode(Request\GetByCode $request)
    {
        $result = $this->_getResponse();
        $entity = $this->_getEntityName();
        $code = $request->getCode();

        $this->_repoBasic->getEntities();
            
        $tbl = $this->_getTableName();
        /** @var  $query \Zend_Db_Select */
        $query = $this->_getConn()->select();
        $query->from($tbl);
        $query->where(BaseTypeEntity::ATTR_CODE . '=:code');
        // $sql = (string)$query;
        $data = $this->_getConn()->fetchRow($query, ['code' => $code]);
        if (is_array($data)) {
            $result->setData($data);
            $result->setErrorCode(Response\GetByCode::ERR_NO_ERROR);
        }
        return $result;
    }

}