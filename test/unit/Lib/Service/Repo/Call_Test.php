<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Lib\Service\Repo;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class Call_UnitTest extends \Praxigento\Core\Lib\Test\BaseTestCase {

    public function test_getEntities_fail() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $mConn
            ->expects($this->once())
            ->method('select')
            ->willReturn($mQuery);
        // $data = $this->_conn->fetchAll($query);
        $mConn
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn(false);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\GetEntities($ENTITY);
        $resp = $call->getEntities($req);
        $this->assertFalse($resp->isSucceed());
    }

    public function test_getEntities_success() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $WHERE = 'condition';
        $FIELDS = '*';
        $ORDER_BY = 'order by';
        $LIMIT = 1;
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $mConn
            ->expects($this->once())
            ->method('select')
            ->willReturn($mQuery);
        // $data = $this->_conn->fetchAll($query);
        $mConn
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn('some value');
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\GetEntities($ENTITY, $WHERE, $FIELDS, $ORDER_BY, $LIMIT);
        $resp = $call->getEntities($req);
        $this->assertTrue($resp->isSucceed());
    }


    public function test_getEntityByPk_fail() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $PK = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $mConn
            ->expects($this->once())
            ->method('select')
            ->willReturn($mQuery);
        // $data = $this->_conn->fetchRow($query, $request->pk);
        $mConn
            ->expects($this->once())
            ->method('fetchRow')
            ->willReturn(false);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\GetEntityByPk($ENTITY, $PK);
        $resp = $call->getEntityByPk($req);
        $this->assertFalse($resp->isSucceed());
    }

    public function test_getEntityByPk_success() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $PK = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $query = $this->_conn->select();
        $mQuery = $this->_mockDbSelect();
        $mConn
            ->expects($this->once())
            ->method('select')
            ->willReturn($mQuery);
        // $data = $this->_conn->fetchRow($query, $request->pk);
        $mConn
            ->expects($this->once())
            ->method('fetchRow')
            ->willReturn([ 'id' => 21 ]);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\GetEntityByPk($ENTITY, $PK);
        $resp = $call->getEntityByPk($req);
        $this->assertTrue($resp->isSucceed());
    }


    public function test_addEntity_success() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $BIND = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        $ID_INSERTED = 1024;
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $rowsAdded = $this->_conn->insert($tbl, $request->bind);
        $mConn
            ->expects($this->once())
            ->method('insert')
            ->willReturn(1);
        // $id = $this->_conn->lastInsertId($tbl);
        $mConn
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn($ID_INSERTED);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\AddEntity();
        $req->setEntity($ENTITY);
        $req->setBind($BIND);
        $resp = $call->addEntity($req);
        $this->assertTrue($resp->isSucceed());
        $this->assertEquals($ID_INSERTED, $resp->getIdInserted());
    }


    public function test_addEntity_fail() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $BIND = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($ENTITY);
        // $rowsAdded = $this->_conn->insert($tbl, $request->bind);
        $mConn
            ->expects($this->once())
            ->method('insert')
            ->willReturn(false);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\AddEntity($ENTITY, $BIND);
        $resp = $call->addEntity($req);
        $this->assertFalse($resp->isSucceed());
    }

    public function test_updateEntity() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $TABLE = 'entity_table_here';
        $BIND = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        $WHERE = 'where clause';
        $ROWS_UPDATED = 1024;
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($TABLE);
        // $rowsUpdated = $this->_conn->update($tbl, $request->bind, $request->where);
        $mConn
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($TABLE), $this->anything(), $this->equalTo($WHERE))
            ->willReturn($ROWS_UPDATED);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\UpdateEntity($ENTITY, $BIND, $WHERE);
        $resp = $call->updateEntity($req);
        $this->assertTrue($resp->isSucceed());
        $this->assertEquals($ROWS_UPDATED, $resp->getRowsUpdated());
    }

    public function test_replaceEntity() {
        /** === Test Data === */
        $ENTITY = 'entity_name_here';
        $TABLE = 'entity_table_here';
        $BIND = [
            'account_id' => 21,
            'datestamp'  => '20151123'
        ];
        /** === Mocks === */
        $mLogger = $this->_mockLogger();
        $mConn = $this->_mockConnection();
        $mDba = $this->_mockDbAdapter(null, $mConn);

        // $tbl = $this->_resource->getTableName($request->entity);
        $mDba
            ->expects($this->once())
            ->method('getTableName')
            ->with($this->equalTo($ENTITY))
            ->willReturn($TABLE);
        /**
         * Prepare request and perform call.
         */
        /** @var  $call Call */
        $call = new Call($mLogger, $mDba);
        $req = new Request\ReplaceEntity($ENTITY, $BIND);
        $resp = $call->replaceEntity($req);
        $this->assertTrue($resp->isSucceed());
    }
}