<?php
/**
 * Base class for Select queries implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Repo\Def;

use Magento\Framework\DB\Select as MageSelect;
use Praxigento\Core\Repo\ISelect;

class Select extends MageSelect implements ISelect
{
}