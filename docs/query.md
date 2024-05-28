# Query 

The query class is used to build the query string for a Directus REST API request.

To begin building a query string, instantiate a new class instance:

```php
use Bayfront\Directus\Query\Query;

$query = new Query();
```

## Public methods

- [getQuery](#getquery)
- [fields](#fields)
- [getFields](#getfields)
- [filter](#filter)
- [getFilter](#getfilter)
- [search](#search)
- [getSearch](#getsearch)
- [sort](#sort)
- [getSort](#getsort)
- [limit](#limit)
- [getLimit](#getlimit)
- [offset](#offset)
- [getOffset](#getoffset)
- [page](#page)
- [getPage](#getpage)
- [aggregate](#aggregate)
- [getAggregate](#getaggregate)
- [groupBy](#groupby)
- [getGroupBy](#getgroupby)

## getQuery

**Description:**

Get query as string or array.

**Parameters:**

- `$array = false` (bool)

**Returns:**

- (string|array)

**Example:**

Example when used with the [DirectusClient](directus-client.md) class:

```php
use Bayfront\Directus\DirectusClient;
use Bayfront\Directus\Query\Query;

$directusClient = new DirectusClient([
    'base_url' => 'https://example.com',
    'access_token' => 'ACCESS_TOKEN'
]);

$query = new Query();

$query->fields([
    'name',
    'contact.email',
    'date_created'
])->limit(50);

$directusClient->get('/contacts/' . $query->getQuery());
```

Returning as an array may be desired in some cases, such as when [updating multiple items](https://docs.directus.io/reference/items.html#update-multiple-items).

## fields

**Description:**

Add fields to be returned.

See: https://docs.directus.io/reference/query.html#fields

**Parameters:**

- `$fields` (array)

**Returns:**

- (self)

## getFields

**Description:**

Get fields to be returned.

**Parameters:**

- None

**Returns:**

- (array)

## filter

**Description:**

Add filter to query.
Each query can only have one filter.

Valid `FieldInterface` includes:

- `Bayfront\Directus\Query\Filter\Fields\LogicalOperator`
- `Bayfront\Directus\Query\Filter\Fields\RelationalField`

The `FieldInterface` makes use of [operator constants](../src/Query/Filter/Operator.php).

**Parameters:**

- `$field` (`FieldInterface`)

**Returns:**

- (self)

**Example:**

### Relational field example

```php
use Bayfront\Directus\DirectusClient;
use Bayfront\Directus\Query\Filter\Fields\RelationalField;
use Bayfront\Directus\Query\Query;

$directusClient = new DirectusClient([
    'base_url' => 'https://example.com',
    'access_token' => 'ACCESS_TOKEN'
]);

$query = new Query();

$query->fields([
    'name',
    'contact.email',
    'date_created'
])->filter(new RelationalField('contact.email', Operator::CONTAINS, '@example.com'))->limit(50);

$directusClient->get('/contacts/' . $query->getQuery());
```

This will create the following filter:

```json
{
  "contact": {
    "email": {
      "_contains": "@example.com"
    }
  }
}
```

### Logical operator example

```php
use Bayfront\Directus\DirectusClient;
use Bayfront\Directus\Query\Filter\Fields\RelationalField;
use Bayfront\Directus\Query\Query;

$directusClient = new DirectusClient([
    'base_url' => 'https://example.com',
    'access_token' => 'ACCESS_TOKEN'
]);

$filter = new LogicalOperator(Operator::LOGICAL_AND);

$filter
    ->field(new RelationalField('contact.email', Operator::ENDS_WITH, '@example.com'))
    ->field(new RelationalField('date_created', Operator::GREATER_THAN_OR_EQUAL, '$NOW(-1 month)'));

$query = new Query();

$query->fields([
    'name',
    'contact.email',
    'date_created'
])->filter($filter)->limit(50);

$directusClient->get('/contacts/' . $query->getQuery());
```

This will create the following filter:

```json
{
  "_and": [
    {
      "contact": {
        "email": {
          "_ends_with": "@example.com"
        }
      }
    },
    {
      "date_created": {
        "_gte": "$NOW(-1 month)"
      }
    }
  ]
}
```

## getFilter

**Description:**

Get filter.

**Parameters:**

- None

**Returns:**

- (array)

## search

**Description:**

String to search.

See: https://docs.directus.io/reference/query.html#search

**Parameters:**

- `$search` (string)

**Returns:**

- (self)

## getSearch

**Description:**

Get search string.

**Parameters:**

- None

**Returns:**

- (string)

## sort

**Description:**

Add field(s) to sort by.

See: https://docs.directus.io/reference/query.html#sort

**Parameters:**

- `$sort` (array)

**Returns:**

- (self)

## getSort

**Description:**

Get field(s) to sort.

**Parameters:**

- None

**Returns:**

- (array)

## limit

**Description:**

Add limit.

See: https://docs.directus.io/reference/query.html#limit

**Parameters:**

- `$limit` (int)

**Returns:**

- (self)

## getLimit

**Description:**

Get limit.

**Parameters:**

- None

**Returns:**

- (int)

## offset

**Description:**

Add offset.

See: https://docs.directus.io/reference/query.html#offset

**Parameters:**

- `$offset` (int)

**Returns:**

- (self)

## getOffset

**Description:**

Get offset.

**Parameters:**

- None

**Returns:**

- (int)

## page

**Description:**

Add page.

See: https://docs.directus.io/reference/query.html#page

**Parameters:**

- `$page` (int)

**Returns:**

- (self)

## getPage

**Description:**

Get page.

**Parameters:**

- None

**Returns:**

- (int)

## aggregate

**Description:**

Add aggregate function.

See: https://docs.directus.io/reference/query.html#aggregation-grouping

**Parameters:**

- `$function` (string): Aggregate constant
- `$value` (string)

Aggregate constants include:

- `AGGREGATE_COUNT`
- `AGGREGATE_COUNT_DISTINCT`
- `AGGREGATE_SUM`
- `AGGREGATE_SUM_DISTINCT`
- `AGGREGATE_AVG`
- `AGGREGATE_AVG_DISTINCT`
- `AGGREGATE_MIN`
- `AGGREGATE_MAX`

**Returns:**

- (self)

**Example:**

```php
$query->aggregate($query::AGGREGATE_COUNT, '*');
```

## getAggregate

**Description:**

Get aggregate function.

**Parameters:**

- None

**Returns:**

- (array)

## groupBy

**Description:**

Add grouping.

See: https://docs.directus.io/reference/query.html#grouping

**Parameters:**

- `$fields` (array)

**Returns:**

- (self)

## getGroupBy

**Description:**

Get grouping.

**Parameters:**

- None

**Returns:**

- (array)