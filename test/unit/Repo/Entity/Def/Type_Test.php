<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Entity\Def;

use Praxigento\Core\Data\Entity\Type\Base as EntityTypeBase;

include_once(__DIR__ . '/../../../phpunit_bootstrap.php');

class ChildToTestType
    extends Type
{
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Repo\IGeneric $repoGeneric
    ) {
        parent::__construct($resource, $repoGeneric, TestTypeEntity::class);
    }

}

class TestTypeEntity
    extends \Praxigento\Core\Data\Entity\Base
{
    const ATTR_ID = 'pkey';
    const ENTITY_NAME = 'test entity';

    public function getPrimaryKeyAttrs()
    {
        return [static::ATTR_ID];
    }

}

class Type_UnitTest
    extends \Praxigento\Core\Test\BaseCase\Repo\Entity
{
    /** @var  ChildToTestType */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create object to test */
        $this->obj = new ChildToTestType(
            $this->mResource,
            $this->mRepoGeneric,
            TestTypeEntity::class
        );
    }

    public function test_getIdByCode()
    {
        /** === Test Data === */
        $CODE = 'code';
        $ID = 43;
        $DATA = [EntityTypeBase::ATTR_ID => $ID];
        /** === Setup Mocks === */
        // $where = EntityTypeBase::ATTR_CODE . '=' . $this->_conn->quote($code);
        $this->mConn
            ->shouldReceive('quote')->once()
            ->andReturn("'$CODE'");
        // $data = $this->_repoGeneric->getEntities($this->_entityName, null, $where);
        $this->mRepoGeneric
            ->shouldReceive('getEntities')->once()
            ->andReturn([$DATA]);
        /** === Call and asserts  === */
        $res = $this->obj->getIdByCode($CODE);
        $this->assertEquals($ID, $res);
    }

}