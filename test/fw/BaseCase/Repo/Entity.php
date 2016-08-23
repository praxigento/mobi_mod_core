<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Test\BaseCase\Repo;

use Mockery as m;

/**
 * Base class to create units to test entities repositories based on \Praxigento\Core\Repo\Def\Entity.
 */
abstract class Entity
    extends \Praxigento\Core\Test\BaseCase\Repo
{
    /** @var  \Mockery\MockInterface */
    protected $mRepoGeneric;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mRepoGeneric = m::mock(\Praxigento\Core\Repo\IGeneric::class);
    }

}