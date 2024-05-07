<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\Directus\Exceptions\DirectusClientException;
use Bayfront\MultiCurl\Client;
use Bayfront\MultiCurl\ClientParent;
use Bayfront\Validator\Validate;

class DirectusClient
{

    private array $config; // Config array
    private array $user; // User of the access token

    /**
     * @param array $config
     * @throws DirectusClientException
     */

    public function __construct(array $config)
    {

        // Validate config

        if (Arr::isMissing($config, [
                'base_url',
                'access_token'
            ])
            || !Validate::url((string)$config['base_url'])
            || !is_string($config['access_token'])) {
            throw new DirectusClientException('Unable to create DirectusClient: Missing or invalid configuration keys');
        }

        // Sanitize
        $config['base_url'] = rtrim((string)$config['base_url'], '/');

        // Save config
        $this->config = $config;

        // Authenticate and save user
        $this->user = $this->get('/users/me');

    }

    /**
     * Return base URL provided in the config array.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->config['base_url'];
    }

    /**
     * Make new API request.
     *
     * @return ClientParent
     */
    private function makeRequest(): ClientParent
    {

        $client = new Client($this->getBaseUrl());

        return $client->setHeaders([
            'Authorization' => 'Bearer ' . $this->config['access_token']
        ]);

    }

    /**
     * Validate API response.
     *
     * @param ClientParent $response
     * @param string $default_message
     * @return ClientParent
     * @throws DirectusClientException
     */
    private function validateResponse(ClientParent $response, string $default_message = 'Unsuccessful response'): ClientParent
    {

        if (!$response->isSuccessful()) {
            throw new DirectusClientException(Arr::get((array)$response->getBody(true, []), 'errors.0.message', $default_message), $response->getStatusCode());
        }

        return $response;

    }

    /**
     * Return response from body, if existing.
     * Otherwise, return an empty array.
     *
     * If response body is not JSON, its value will exist in a key named "value".
     *
     * If "data" key exists, only its value is returned.
     *
     * @param ClientParent $response
     * @return array
     */
    private function getResponse(ClientParent $response): array
    {

        $body = $response->getBody();

        if ($body === null) {
            return [];
        }

        /*
         * Body is not always JSON.
         * Example: https://docs.directus.io/reference/system/server.html#ping
         */

        if (Validate::json($body)) {
            $body = json_decode($body, true);
        } else {
            $body = [
                'value' => $body
            ];
        }

        /*
         * "data" key does not always exist.
         * Example: https://docs.directus.io/reference/system/server.html#health
         */

        if (isset($body['data'])) {
            return $body['data'];
        }

        return $body;

    }

    /**
     * Get current user array.
     *
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * Perform a GET request to the API.
     *
     * @param string $path
     * @return array
     * @throws DirectusClientException
     */
    public function get(string $path): array
    {
        $response = $this->makeRequest()->get($path);
        $response = $this->validateResponse($response, 'Unable to make GET request');
        return $this->getResponse($response);
    }

    /**
     * Perform a DELETE request to the API.
     *
     * @param string $path
     * @param array $data
     * @return void
     * @throws DirectusClientException
     */
    public function delete(string $path, array $data = []): void
    {
        $response = $this->makeRequest()->delete($path, $data, true);
        $this->validateResponse($response, 'Unable to make DELETE request');
    }

    /**
     * Perform a PATCH request to the API.
     *
     * @param string $path
     * @param array $data
     * @return array
     * @throws DirectusClientException
     */
    public function patch(string $path, array $data = []): array
    {
        $response = $this->makeRequest()->patch($path, $data, true);
        $response = $this->validateResponse($response, 'Unable to make PATCH request');
        return $this->getResponse($response);
    }

    /**
     * Perform a POST request to the API.
     *
     * @param string $path
     * @param array $data
     * @return array
     * @throws DirectusClientException
     */
    public function post(string $path, array $data = []): array
    {
        $response = $this->makeRequest()->post($path, $data, true);
        $response = $this->validateResponse($response, 'Unable to make POST request');
        return $this->getResponse($response);
    }

}