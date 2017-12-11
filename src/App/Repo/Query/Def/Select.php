<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Repo\Query\Def;

/**
 * Wrapper for Magento SELECT with own marker ISelect.
 */
class Select
    extends \Magento\Framework\DB\Select
    implements \Praxigento\Core\App\Repo\Query\ISelect
{
}