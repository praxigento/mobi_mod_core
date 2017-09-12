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
     * Add new pair key:value to the mapper.
     *
     * @param string $key
     * @param string $value
     */
    public function add($key, $value);

    /**
     * Get mapped value for $key.
     *
     * @param string $key
     * @return string
     */
    public function get($key);
}