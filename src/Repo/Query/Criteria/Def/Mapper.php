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
    /** @var array */
    protected $_map = [];

    public function get($key)
    {
        $result = $this->_map[$key]??$key;
        return $result;
    }
}