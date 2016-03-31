<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Lib\Entity;

use Flancer32\Lib\DataObject;

/**
 * Base class for persistence entities (match to tables/views in DB).
 */
abstract class Base extends DataObject implements \Praxigento\Core\Lib\Data\IEntity
{

}