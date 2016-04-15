<?php
/**
 * Base class for services requests implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service\Base;

use Flancer32\Lib\DataObject;
use Praxigento\Core\Service\IRequest;

abstract class Request extends DataObject implements IRequest
{

}