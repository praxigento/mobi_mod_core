<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Plugin\Framework\Webapi\Sub;

/**
 * Property Data Object for TypePropertiesRegistry.
 *
 * @method string getName() Name of the property (getSomeProperty() => 'someProperty').
 * @method void setName(string $data)
 * @method boolean getIsRequired() 'false' - if return type of the getter contains '|null', 'true' - otherwise.
 * @method void setIsRequired(boolean $data)
 * @method string getType() Type of the property (complex, not simple - see \Magento\Framework\Reflection\TypeProcessor::isTypeSimple).
 * @method void setType(string $data)
 * @method boolean getIsArray() 'true' if property is an array of $types.
 * @method void setIsArray(boolean $data)
 */
class PropertyData
    extends \Flancer32\Lib\DataObject
{

}