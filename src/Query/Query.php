<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus\Query;

use Bayfront\Directus\Query\Interfaces\FieldInterface;

class Query
{

    /**
     * Get query.
     *
     * @param bool $url_encode
     * @return string
     */
    public function getQuery(bool $url_encode = true): string
    {

        $query = '';

        // Fields

        if (!empty($this->getFields())) {
            $query .= '&fields[]=' . implode(',', $this->getFields());
        }

        // Filter

        if (!empty($this->getFilter())) {
            $query .= '?filter=' . json_encode($this->getFilter());
        }

        // Search

        if ($this->getSearch() != '') {
            $query .= '&search=' . $this->getSearch();
        }

        // Sort

        if (!empty($this->getSort())) {
            $query .= '&sort[]=' . implode(',', $this->getSort());
        }

        // Limit

        if ($this->getLimit() !== 0) {
            $query .= '&limit=' . $this->getLimit();
        }

        // Offset

        if ($this->getOffset() !== 0) {
            $query .= '&offset=' . $this->getOffset();
        }

        // Page

        if ($this->getPage() !== 0) {
            $query .= '&page=' . $this->getPage();
        }

        // Aggregate

        if (!empty($this->getAggregate())) {

            foreach ($this->getAggregate() as $k => $v) {
                $query .= '&aggregate[' . $k . ']=' . $v;
            }

        }

        // Group by

        if (!empty($this->getGroupBy())) {
            $query .= '&groupBy[]=' . implode(',', $this->getGroupBy());
        }

        // Sanitize

        if ($query == '') {
            return $query;
        }

        $query = ltrim($query, '&');
        $query = '?' . $query;

        if ($url_encode) {
            return urlencode($query);
        }

        return $query;

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
     * @param FieldInterface $field
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
     * Get fields to sort.
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