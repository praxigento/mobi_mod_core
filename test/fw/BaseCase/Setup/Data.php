<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase\Setup;

use Mockery as m;

/**
 * Base class to create units to test data install classes
 * bases on \Praxigento\Core\App\Setup\Data\Base.
 */
abstract class Data
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    protected $mConn;
    /** @var  \Mockery\MockInterface */
    protected $mContext;
    /** @var  \Mockery\MockInterface */
    protected $mRepoGeneric;
    /** @var  \Mockery\MockInterface */
    protected $mResource;
    /** @var  \Mockery\MockInterface */
    protected $mSetup;
    /** @var  \Mockery\MockInterface */
    protected $mToolDem;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mConn = m::mock(\Magento\Framework\DB\Adapter\AdapterInterface::class);
        $this->mContext = m::mock(\Magento\Framework\Setup\ModuleContextInterface::class);
        $this->mRepoGeneric = m::mock(\Praxigento\Core\Api\App\Repo\Generic::class);
        $this->mResource = m::mock(\Magento\Framework\App\ResourceConnection::class);
        $this->mSetup = m::mock(\Magento\Framework\Setup\ModuleDataSetupInterface::class);
        $this->mToolDem = m::mock(\Praxigento\Core\App\Setup\Dem\Tool::class);
        /** setup mocks for constructor */
        $this->mResource
            ->shouldReceive('getConnection')->once()
            ->andReturn($this->mConn);
    }

}