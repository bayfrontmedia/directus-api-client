# Directus client

The `DirectusClient` class requires a configuration array be passed to its constructor.

The configuration array requires the following keys:

- `base_url`: Base URL to the Directus API
- `access_token`: Static user token (
  see [Directus docs](https://docs.directus.io/reference/authentication.html#access-tokens))

The access token will be authenticated immediately.

Example:

```php
use Bayfront\Directus\DirectusClient;

$directusClient = new DirectusClient([
    'base_url' => 'https://example.com',
    'access_token' => 'ACCESS_TOKEN'
]);
```

When a response is received from the Directus API, its contents are evaluated.

If an object is returned without a body, an empty array is returned.
If the body is not JSON (i.e. a string), its value will exist in a key named `value`.
If the body contains a `data` key, only its value is returned.

The [query builder](query.md) can be used to build the query string as an alternative to passing the
`data` array to any of the public methods.

## Public methods

- [getBaseUrl](#getbaseurl)
- [getUser](#getuser)
- [get](#get)
- [delete](#delete)
- [patch](#patch)
- [post](#post)

## getBaseUrl

**Description:**

Return base URL provided in the config array.

**Parameters:**

- None

**Returns:**

- (string)

## getUser

**Description:**

Get current user array.

**Parameters:**

- None

**Returns:**

- (array)

## get

**Description:**

Perform a GET request to the API.

**Parameters:**

- `$path` (string)

**Returns:**

- (array)

**Throws:**

- `\Bayfront\Directus\Exceptions\DirectusClientException`

## delete

**Description:**

Perform a DELETE request to the API.

**Parameters:**

- `$path` (string)
- `$data = []` (array)

**Returns:**

- (void)

**Throws:**

- `\Bayfront\Directus\Exceptions\DirectusClientException`

## patch

**Description:**

Perform a PATCH request to the API.

**Parameters:**

- `$path` (string)
- `$data = []` (array)

**Returns:**

- (array)

**Throws:**

- `\Bayfront\Directus\Exceptions\DirectusClientException`

## post

**Description:**

Perform a POST request to the API.

**Parameters:**

- `$path` (string)
- `$data = []` (array)

**Returns:**

- (array)

**Throws:**

- `\Bayfront\Directus\Exceptions\DirectusClientException`