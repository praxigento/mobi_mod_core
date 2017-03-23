<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\Reflection\Data;

/**
 * Data object for reflected method.
 *
 * @method string getName() Name of the method ('getSomething', 'addOrder').
 * @method void setName(string $data)
 * @method string getType() Return type of the method's data.
 * @method void setType(string $data)
 * @method boolean getIsRequired()
 * @method void setIsRequired(boolean $data)
 * @method boolean getDescription() Description of the method.
 * @method void setDescription(string $data)
 * @method int getParameterCount() Number of the input parameters for the method.
 * @method void setParameterCount(int $data)
 * @method string getParamsDefinition() Parameters definition ("type $attr='value', ...")
 * @method void setParamsDefinition(string $data)
 */
class Method
    extends \Flancer32\Lib\Data
{

}