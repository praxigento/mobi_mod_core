<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Api\Processor\WithQuery;

/**
 * Alias structure to represent result set attribute ("SELECT `table`.`field` AS `alias`, ...")
 *
 * @method string getAlias()
 * @method void setAlias(string $data)
 * @method string getTable()
 * @method void setTable(string $data)
 * @method string getField()
 * @method void setField(string $data)
 *
 */
class Alias
    extends \Flancer32\Lib\Data
{

}