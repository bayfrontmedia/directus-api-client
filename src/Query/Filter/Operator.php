<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus\Query\Filter;

/**
 * Operator constants.
 */
class Operator
{

    /*
     * Filter operators
     * See: https://docs.directus.io/reference/filter-rules.html#filter-operators
     */

    public const EQUALS = '_eq';
    public const NOT_EQUALS = '_neq';
    public const LESS_THAN = '_lt';
    public const LESS_THAN_OR_EQUAL = '_lte';
    public const GREATER_THAN = '_gt';
    public const GREATER_THAN_OR_EQUAL = '_gte';
    public const ONE_OF = '_in';
    public const NOT_ONE_OF = '_nin';
    public const NULL = '_null';
    public const NOT_NULL = '_nnull';
    public const CONTAINS = '_contains';
    public const CONTAINS_INSENSITIVE = '_icontains';
    public const NOT_CONTAINS = '_ncontains';
    public const STARTS_WITH = '_starts_with';
    public const STARTS_WITH_INSENSITIVE = '_istarts_with';
    public const NOT_STARTS_WITH = '_nstarts_with';
    public const NOT_STARTS_WITH_INSENSITIVE = '_nistarts_with';
    public const ENDS_WITH = '_ends_with';
    public const ENDS_WITH_INSENSITIVE = '_iends_with';
    public const NOT_ENDS_WITH = '_nends_with';
    public const NOT_ENDS_WITH_INSENSITIVE = '_niends_with';
    public const BETWEEN = '_between';
    public const NOT_BETWEEN = '_nbetween';
    public const EMPTY = '_empty';
    public const NOT_EMPTY = '_nempty';
    public const INTERSECTS = '_intersects';
    public const NOT_INTERSECTS = '_nintersects';
    public const INTERSECTS_BOUNDING_BOX = '_intersects_bbox';
    public const NOT_INTERSECTS_BOUNDING_BOX = '_nintersects_bbox';

    /*
     * Logical operators
     * See: https://docs.directus.io/reference/filter-rules.html#logical-operators
     */

    public const LOGICAL_AND = '_and';
    public const LOGICAL_OR = '_or';

}