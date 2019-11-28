<?php

namespace App\Location;

use Illuminate\Support\Collection;
use Symfony\Component\HttpClient\HttpClient;
use App\Location\Exceptions\LocationException;
use App\Location\Exceptions\InvalidCredentialsException;

abstract class AbstractLocation
{
    /** @var int */
    protected $status;

    /** @var \Symfony\Contracts\HttpClient\HttpClientInterface|null */
    protected $client;

    /**
     * Construct a new HereApi instance.
     *
     * @param  array  $credentials
     * @param  array  $headers
     */
    public function __construct(array $credentials, array $headers = [])
    {
        $this->headers = $headers;
        $this->setCredentials($credentials);

        $this->client = HttpClient::create([
            'headers' => $headers,
        ]);
    }

    /**
     * @throws \App\Location\Exceptions\LocationException
     *
     * @return mixed|string
     */
    protected function makeRequest(string $uri, array $params = [], string $method = 'GET')
    {
        $this->checkCredentials();

        $options = $this->getOptions($params);

        $response = $this->client->request(strtoupper($method), $uri, $options);
        $content = json_decode($response->getContent(), true);

        $status = $response->getStatusCode();

        if (200 !== $status) {
            throw new LocationException("Response returned with status: {$status} \n {$content->message}");
        }

        $this->setStatus((int) $status);

        return $content;
    }

    /**
     * Get the response status.
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status.
     */
    protected function setStatus(int $status): AbstractLocation
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the api request options.
     */
    protected function getOptions(array $params): array
    {
        $options = [];

        $options['query'] = $params;

        foreach ($this->credentials as $credential => $value) {
            $options['query'][$credential] = $value;
        }

        if (! empty($this->headers)) {
            $options['headers'] = $this->headers;
        }

        return $options;
    }

    /**
     * Set the credentials for the api.
     *
     * @param  array  $credentials
     *
     * @throws \App\Location\Exceptions\InvalidCredentialsException
     */
    protected function setCredentials(array $credentials): array
    {
        if (! $this->credentials) {
            throw new InvalidCredentialsException(sprintf('Credentials property for %s, not found.', static::class));
        }
        if (! $credentials) {
            throw new InvalidCredentialsException(sprintf('No credentials were provided to the setCredentials method of class, %s.', static::class));
        }
        if (array_keys($this->credentials) !== array_keys($credentials)) {
            throw new InvalidCredentialsException(sprintf('The provided credentials do not match the expected credentials for class, %s.', static::class));
        }

        return $this->credentials = $credentials;
    }

    /**
     * Check the existence of api credentials.
     *
     * @throws \App\Locataion\Exceptions\InvalidCredentialsException
     */
    protected function checkCredentials(): bool
    {
        if (! $this->credentials) {
            throw new InvalidCredentialsException(sprintf('Credentials for %s, not found.', static::class));
        }

        foreach ($this->credentials as $credential => $value) {
            if (! $credential) {
                throw new InvalidCredentialsException(sprintf('Credentials for %s, not found.', static::class));
            }
        }

        return true;
    }

    /**
     * Convert the given response to a Collection.
     *
     * @param  mixed  $data
     * @param  mixed|null  $index
     */
    protected function convertToCollection($data, $index = null): Collection
    {
        $data = collect($data);

        return $index ? collect(data_get($data, $index)) : $data;
    }
}
