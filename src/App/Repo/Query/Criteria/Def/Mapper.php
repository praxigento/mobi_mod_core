<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\Repo\Query\Criteria\Def;

/**
 * Default mapper does not map $keys, just returns it.
 */
class Mapper
    implements \Praxigento\Core\App\Repo\Query\Criteria\IMapper
{
    /** @var array */
    protected $map = [];

    public function __construct($map = null)
    {
        if (is_array($map)) {
            $this->map = $map;
        }
    }

    public function add($key, $value)
    {
        $this->map[$key] = $value;
    }

    public function get($key)
    {
        $result = $this->map[$key] ?? $key;
        return $result;
    }
}