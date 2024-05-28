<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus\Query;

use Bayfront\Directus\Query\Interfaces\FieldInterface;

/**
 * Used to build the query string for a Directus REST API request.
 */
class Query
{

    /**
     * Get query as string or array.
     *
     * @param bool $array
     * @return string|array
     */
    public function getQuery(bool $array = false): string|array
    {

        $query = [];

        if (!empty($this->getFields())) {
            $query['fields'] = $this->getFields();
        }

        if (!empty($this->getFilter())) {
            $query['filter'] = $this->getFilter();
        }

        if ($this->getSearch() !== '') {
            $query['search'] = $this->getSearch();
        }

        if (!empty($this->getSort())) {
            $query['sort'] = $this->getSort();
        }

        if ($this->getLimit() !== 0) {
            $query['limit'] = $this->getLimit();
        }

        if ($this->getOffset() !== 0) {
            $query['offset'] = $this->getOffset();
        }

        if ($this->getPage() !== 0) {
            $query['page'] = $this->getPage();
        }

        if (!empty($this->getAggregate())) {
            foreach ($this->getAggregate() as $k => $v) {
                $query['aggregate'][$k] = $v;
            }
        }

        if (!empty($this->getGroupBy())) {
            $query['groupBy'] = $this->getGroupBy();
        }

        if ($array === true) {
            return $query;
        }

        $string = '';

        // Fields

        if (isset($query['fields'])) {
            $string .= '&fields[]=' . implode(',', $query['fields']);
        }

        // Filter

        if (isset($query['filter'])) {
            $string .= '&filter=' . json_encode($query['filter']);
        }

        // Search

        if (isset($query['search'])) {
            $string .= '&search=' . $query['search'];
        }

        // Sort

        if (isset($query['sort'])) {
            $string .= '&sort[]=' . implode(',', $query['sort']);
        }

        // Limit

        if (isset($query['limit'])) {
            $string .= '&limit=' . $query['limit'];
        }

        // Offset

        if (isset($query['offset'])) {
            $string .= '&offset=' . $query['offset'];
        }

        // Page

        if (isset($query['page'])) {
            $string .= '&page=' . $query['page'];
        }

        // Aggregate

        if (isset($query['aggregate'])) {

            foreach ($query['aggregate'] as $k => $v) {
                $string .= '&aggregate[' . $k . ']=' . $v;
            }

        }

        // Group by

        if (isset($query['groupBy'])) {
            $string .= '&groupBy[]=' . implode(',', $query['groupBy']);
        }

        // Sanitize

        $string = str_replace(' ', '+', $string); // Replace spaces

        if ($string == '') {
            return $string;
        }

        return  '?' . ltrim($string, '&');

    }

    private array $fields = [];

    /**
     * Add fields to be returned.
     * See: https://docs.directus.io/reference/query.html#fields
     *
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = array_unique(array_merge($this->fields, $fields));
        return $this;
    }

    /**
     * Get fields to be returned.
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    private array $filter = [];

    /**
     * Add filter to query.
     * Each query can only have one filter.
     *
     * @param FieldInterface $field (RelationalField or LogicalOperator)
     * @return $this
     */
    public function filter(FieldInterface $field): self
    {
        $this->filter = $field->get();
        return $this;
    }

    /**
     * Get filter.
     *
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    private string $search = '';

    /**
     * String to search.
     * See: https://docs.directus.io/reference/query.html#search
     *
     * @param string $search
     * @return $this
     */
    public function search(string $search): self
    {
        $this->search = $search;
        return $this;
    }

    /**
     * Get search string.
     *
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    private array $sort = [];

    /**
     * Add field(s) to sort by.
     * See: https://docs.directus.io/reference/query.html#sort
     *
     * @param array $sort (Array of fields to sort by)
     * @return $this
     */
    public function sort(array $sort): self
    {
        $this->sort = array_unique(array_merge($this->sort, $sort));
        return $this;
    }

    /**
     * Get field(s) to sort.
     *
     * @return array
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    private int $limit = 0;

    /**
     * Add limit.
     * See: https://docs.directus.io/reference/query.html#limit
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    private int $offset = 0;

    /**
     * Add offset.
     * See: https://docs.directus.io/reference/query.html#offset
     *
     * @param int $offset
     * @return Query
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Get offset.
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    private int $page = 0;

    /**
     * Add page.
     * See: https://docs.directus.io/reference/query.html#page
     *
     * @param int $page
     * @return self
     */
    public function page(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get page.
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    public const AGGREGATE_COUNT = 'count';
    public const AGGREGATE_COUNT_DISTINCT = 'countDistinct';
    public const AGGREGATE_SUM = 'sum';
    public const AGGREGATE_SUM_DISTINCT = 'sumDistinct';
    public const AGGREGATE_AVG = 'avg';
    public const AGGREGATE_AVG_DISTINCT = 'avgDistinct';
    public const AGGREGATE_MIN = 'min';
    public const AGGREGATE_MAX = 'max';

    private array $aggregate = [];

    /**
     * Add aggregate function.
     * See: https://docs.directus.io/reference/query.html#aggregation-grouping
     *
     * @param string $function (Aggregate constant)
     * @param string $value
     * @return $this
     */
    public function aggregate(string $function, string $value): self
    {
        $this->aggregate[$function] = $value;
        return $this;
    }

    /**
     * Get aggregate function.
     *
     * @return array
     */
    public function getAggregate(): array
    {
        return $this->aggregate;
    }

    private array $group = [];

    /**
     * Add grouping.
     *
     * See: https://docs.directus.io/reference/query.html#grouping
     *
     * @param array $fields
     * @return $this
     */
    public function groupBy(array $fields): self
    {
        $this->group = array_unique(array_merge($this->group, $fields));
        return $this;
    }

    /**
     * Get grouping.
     *
     * @return array
     */
    public function getGroupBy(): array
    {
        return $this->group;
    }

}