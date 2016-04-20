<?php
/**
 * Base class to create units to test Entities Repos.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Test;

use Mockery as m;

abstract class BaseRepoEntityCase extends BaseMockeryCase
{
    /** @var  \Mockery\MockInterface */
    protected $mConn;
    /** @var  \Mockery\MockInterface */
    protected $mRepoGeneric;
    /** @var  \Mockery\MockInterface */
    protected $mResource;

    protected function setUp()
    {
        parent::setUp();
        /* create mocks */
        $this->mConn = $this->_mockConn();
        $this->mResource = $this->_mockResourceConnection($this->mConn);
        $this->mRepoGeneric = $this->_mockRepoGeneric();
    }

}