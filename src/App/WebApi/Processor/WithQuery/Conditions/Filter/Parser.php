<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App\WebApi\Processor\WithQuery\Conditions\Filter;


/**
 * Parser for 'filter' conditions. Converts tree-like structure into SQL WHERE string.
 */
class Parser
{
    /**
     * Placeholders for parts of the clause.
     */
    const PH_ATTR = '${ATTR}';
    const PH_VAL = '${VAL}';

    /** @var \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $dba;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        /* I need 'quote' function only but I need to get whole resource */
        $dba = $resource->getConnection();
        $this->dba = $dba;
    }

    /**
     * @param $alias
     * @param $aliases
     * @return \Praxigento\Core\Repo\Query\Expression|string
     */
    protected function mapAlias($alias, $aliases)
    {
        $data = $aliases[$alias];
        $table = $data->getTable();
        $field = $data->getField();
        if ($field instanceof \Praxigento\Core\Repo\Query\Expression) {
            /* this is an expression, don't use table alias and backquotes */
            $result = $field;
        } else {
            $result = "`$table`.`$field`";
        }
        return $result;
    }

    /**
     * Parse tree-like filter structure and return string for SQL 'WHERE' clause.
     *
     * @param \Praxigento\Core\App\WebApi\Request\Part\Conditions\Filter $filter
     * @param \Praxigento\Core\App\WebApi\Processor\WithQuery\Alias[] $aliases map of the aliases to [table, field]
     * @return string
     */
    public function parse($filter, $aliases)
    {
        $result = '';
        /* Filter can be a single 'clause' or single 'group' */
        $clause = $filter->getClause();
        if (is_array($clause)) $clause = new \Praxigento\Core\App\WebApi\Request\Part\Conditions\Filter\Clause($clause);
        $group = $filter->getGroup();
        if (is_array($group)) $group = new \Praxigento\Core\App\WebApi\Request\Part\Conditions\Filter\Group($group);
        if ($clause) {
            /* there is single filtering clause in the filter */
            $attr = $clause->getAttr(); // required
            $func = $clause->getFunc(); // required
            /* one of them or nothing is allowed */
            $args = $clause->getArgs(); // is not used yet
            $value = $clause->getValue();
            /* compose clause */
            $valAttr = $this->mapAlias($attr, $aliases);
            $valLvalue = $this->dba->quote($value);
            $template = $this->parseFunc($func);
            $template = str_replace(self::PH_ATTR, $valAttr, $template);
            $template = str_replace(self::PH_VAL, $valLvalue, $template);
            $result = $template;
        } elseif ($group) {
            /* there is single group of the filtering clauses in the filter */
            $with = $group->getWith();
            $entries = $group->getEntries();
            /* collect group parts as SQL */
            $parts = [];
            /** @var \Praxigento\Core\App\WebApi\Request\Part\Conditions\Filter $entry */
            foreach ($entries as $entry) {
                /* place data into 'filter' container */
                if (is_array($entry)) $entry = new \Praxigento\Core\App\WebApi\Request\Part\Conditions\Filter($entry);
                $sql = $this->parse($entry, $aliases);
                $parts[] = $sql;
            }
            /* concatenate group parts using $with */
            foreach ($parts as $part) {
                if ($part) $result .= "($part) $with ";
            }
            /* cut the last $with */
            $tail = substr($result, -1 * (strlen($with) + 2));
            if ($tail == " $with ") {
                $result = substr($result, 0, strlen($result) - strlen($tail));
            }
        }
        return $result;
    }

    /**
     * Convert function name into template with placeholders fro function arguments.
     *
     * @param string $func
     * @return string template with placeholders.
     */
    protected function parseFunc($func)
    {
        $result = '';
        switch (strtolower(trim($func))) {
            case 'eq':
                $result = self::PH_ATTR . ' = ' . self::PH_VAL;
                break;
            case 'neq':
                $result = self::PH_ATTR . ' <> ' . self::PH_VAL;
                break;
            case 'gt':
                $result = self::PH_ATTR . ' > ' . self::PH_VAL;
                break;
            case 'gte':
                $result = self::PH_ATTR . ' >= ' . self::PH_VAL;
                break;
            case 'lt':
                $result = self::PH_ATTR . ' < ' . self::PH_VAL;
                break;
            case 'lte':
                $result = self::PH_ATTR . ' <= ' . self::PH_VAL;
                break;
            case 'like':
                $result = self::PH_ATTR . ' LIKE ' . self::PH_VAL;
                break;
            case 'is_null':
                $result = self::PH_ATTR . ' IS NULL';
                break;
            case 'is_not_null':
                $result = self::PH_ATTR . ' IS NOT NULL';
                break;
        }
        return $result;
    }
}