<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase;

use Mockery as m;

/**
 * Base class to create units to test repositories based on \Praxigento\Core\Repo\Def\Db.
 */
abstract class Repo
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    protected $mConn;
    /** @var  \Mockery\MockInterface */
    protected $mResource;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = m::mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        $this->mResource = m::mock(\Magento\Framework\App\ResourceConnection::class);
        /** setup mocks for constructor */
        $this->mResource
            ->shouldReceive('getConnection')
            ->andReturn($this->mConn);
    }

}