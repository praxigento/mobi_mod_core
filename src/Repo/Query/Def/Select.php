<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Query\Def;

/**
 * Wrapper for Magento SELECT with own marker ISelect.
 */
class Select
    extends \Magento\Framework\DB\Select
    implements \Praxigento\Core\Repo\Query\ISelect
{
}