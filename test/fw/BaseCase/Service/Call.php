<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase\Service;

use Mockery as m;

/**
 * Base class to create units to test services
 * based on \Praxigento\Core\App\Service\Base\Call.
 */
abstract class Call
    extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    protected $mLogger;
    /** @var  \Mockery\MockInterface */
    protected $mManObj;

    protected function setUp(): void
    {
        parent::setUp();
        /** create mocks */
        $this->mLogger = $this->_mockLogger();
        $this->mManObj = $this->_mockObjectManager();
    }
}
