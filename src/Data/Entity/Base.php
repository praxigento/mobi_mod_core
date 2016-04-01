<?php
/**
 * Base class for persistence entities (match to tables/views in DB).
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Data\Entity;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Data\IEntity;

abstract class Base extends DataObject implements IEntity
{

}