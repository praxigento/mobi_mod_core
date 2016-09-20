<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query\Criteria;

/**
 * Map some data from one context to another (from API to SQL).
 */
interface IMapper
{
    /**
     * Get mapped value for $key.
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

}