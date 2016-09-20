<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Repo\Query\Criteria\Def;

/**
 * Default mapper does not map $keys, just returns it.
 */
class Mapper
    implements \Praxigento\Core\Repo\Query\Criteria\IMapper
{

    public function get($key)
    {
        return $key;
    }

}