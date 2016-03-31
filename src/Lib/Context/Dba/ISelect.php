<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Context\Dba;


interface ISelect {

    public function from($name, $cols = null);

    public function group($spec);

    public function joinLeft($name, $cond, $cols);

    public function limit($count, $offset = null);

    public function order($spec);

    public function where($cond, $value = null);
}