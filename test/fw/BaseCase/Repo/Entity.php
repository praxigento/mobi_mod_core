<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase\Repo;

use Mockery as m;

/**
 * Base class to create units to test entities repositories
 * based on \Praxigento\Core\App\Repo\Entity.
 */
abstract class Entity
    extends \Praxigento\Core\Test\BaseCase\Repo
{
    /** @var  \Mockery\MockInterface */
    protected $mRepoGeneric;

    protected function setUp(): void
    {
        parent::setUp();
        /** create mocks */
        $this->mRepoGeneric = m::mock(\Praxigento\Core\Api\App\Repo\Generic::class);
    }

}
