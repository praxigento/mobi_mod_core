<?php
/**
 * DEM (Domain entities map) related types.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Setup\Dem;

class DemType
{

    /**
     * Attribute subtypes modifiers.
     */

    const ATTRSUB_SMALL_INT = 'smallint';

    /**
     * Attribute types.
     */

    const A_BINARY = 'binary';
    const A_BOOLEAN = 'boolean';
    const A_DATETIME = 'datetime';
    const A_INTEGER = 'integer';
    const A_NUMERIC = 'numeric';
    const A_OPTION = 'option';
    const A_TEXT = 'text';

    /**
     * Default values for attributes.
     */

    const DEF_CURRENT = 'current';

    /**
     * Index types.
     */

    const INDEX_PRIMARY = 'primary';
    const INDEX_SIMPLE = 'simple';
    const INDEX_TEXT = 'text';
    const INDEX_UNIQUE = 'unique';

    /**
     * References action.
     */

    const REF_ACTION_CASCADE = 'cascade';
    const REF_ACTION_RESTRICT = 'restrict';
}