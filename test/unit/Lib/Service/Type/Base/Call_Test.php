<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Type\Base;

use Praxigento\Core\Lib\Entity\Type\Base as BaseTypeCode;

include_once(__DIR__ . '/../../../../phpunit_bootstrap.php');

class Call_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_getByCode() {
        /** === Test Data === */
        $TABLE = 'table name here';
        $CODE = 'some code';
        $ID = 43;
        $NOTE = 'note is here';
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);
        $mToolbox = $this->_mockToolbox();
        $mCallRepo = $this->_mockCallRepo();

        $mCall = $this
            ->getMockBuilder('Praxigento\Core\Lib\Service\Type\Base\Call')
            ->setConstructorArgs([ $mLogger, $mDba, $mToolbox, $mCallRepo ])
            ->setMethods([ '_getResponse', '_getEntityName' ])
            ->getMock();
        // $result = $this->_getResponse();
        $mResp = $this->_mockFor('Praxigento\Core\Lib\Service\Type\Base\Response\GetByCode', [ 'getErrorMessage' ]);
        $mCall
            ->expects($this->once())
            ->method('_getResponse')
            ->willReturn($mResp);
        //  $code = $request->getData(Request\GetByCode::CODE);
        $mReq = $this->_mockFor('Praxigento\Core\Lib\Service\Type\Base\Request\GetByCode', [ 'getCode' ]);
        $mReq
            ->expects($this->once())
            ->method('getCode')
            ->willReturn($CODE);
        // $tbl = $this->_resource->getTableName($this->_getEntityName());
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->willReturn($TABLE);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $mConn
            ->expects($this->once())
            ->method('select')
            ->willReturn($mQuery);
        // $data = $this->_conn->fetchRow($query, [ 'code' => $code ]);
        $mConn
            ->expects($this->once())
            ->method('fetchRow')
            ->willReturn([
                BaseTypeCode::ATTR_ID   => $ID,
                BaseTypeCode::ATTR_CODE => $CODE,
                BaseTypeCode::ATTR_NOTE => $NOTE
            ]);
        /**
         * Prepare request and perform call.
         */
        /** @var  $resp Response\GetByCode */
        $resp = $mCall->getByCode($mReq);
        $this->assertEquals($ID, $resp->getId());
        $this->assertEquals($CODE, $resp->getCode());
        $this->assertEquals($NOTE, $resp->getNote());
    }

}