<?php

namespace App\Here;

use Illuminate\Support\Collection;
use App\Here\Exceptions\HereApiException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HereApi
{
    const PLACES_BASE_URL = 'https://places.api.here.com/places/v1/';

    const BROWSE_PATH = 'browse';

    const AUTOCOMPLETE_URL = 'http://autocomplete.geocoder.api.here.com/6.2/suggest.json';

    const GEOCODE_URL = 'http://geocoder.api.here.com/6.2/geocode.json';

    /** @var int */
    private $status;

    /** @var \Symfony\Contracts\HttpClient\HttpClientInterface|null */
    private $client;

    /** @var $appId */
    private $appId;

    /** @var $appCode */
    private $appCode;

    /**
     * Construct a new HereApi instance.
     */
    public function __construct(string $appId, string $appCode, array $headers)
    {
        $this->headers = $headers;
        $this->appId = $appId;
        $this->appCode = $appCode;

        $this->client = HttpClient::create([
            'headers' => $headers,
        ]);
    }

    /**
     * Get the underlying HttpClient.
     */
    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }

    /**
     * Search for places in the given radius for the given location, using the given options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function search(array $options)
    {
        $this->checkCredentials();

        $response = $this->makeRequest(self::PLACES_BASE_URL.self::BROWSE_PATH, $options);

        return $this->convertToCollection($response, 'results.items');
    }

    /**
     * Autosuggest addresses based on partial input from the user.
     *
     * @param  string  $query
     *
     * @return \Illuminate\Support\Collection
     */
    public function autosuggest(?string $search = '')
    {
        $this->checkCredentials();

        $response = $this->makeRequest(self::AUTOCOMPLETE_URL, ['query' => $search, 'maxresults' => 3]);

        return $this->convertToCollection($response, 'suggestions');
    }

    /**
     * Geocode a location based on the given locationId.
     */
    public function geocodeFromLocationid(string $locationId): array
    {
        $this->checkCredentials();

        $response = $this->makeRequest(self::GEOCODE_URL, [
            'locationId' => $locationId,
            'jsonattributes' => 1,
            'gen' => 9,
        ]);

        return $response['response']['view'][0]['result'][0]['location']['displayPosition'];
    }

    /**
     * @throws \App\GooglePlaces\Exceptions\HereApiException
     *
     * @return mixed|string
     */
    private function makeRequest(string $uri, array $params, string $method = 'GET')
    {
        $options = $this->getOptions($params);

        $response = $this->client->request(strtoupper($method), $uri, $options);
        $content = json_decode($response->getContent(), true);

        $status = $response->getStatusCode();

        if (200 !== $status) {
            throw new HereApiException("Response returned with status: {$status} \n {$content->message}");
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
    private function setStatus(int $status): HereApi
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the search options.
     */
    private function getOptions(array $params): array
    {
        $options = [];

        $options['query'] = $params;
        $options['query']['app_id'] = $this->appId;
        $options['query']['app_code'] = $this->appCode;

        if (! empty($this->headers)) {
            $options['headers'] = $this->headers;
        }

        return $options;
    }

    /**
     * Check the existence of the Places API clientId.
     *
     * @throws \App\HereApi\Exceptions\HereApiException
     */
    private function checkCredentials(): void
    {
        if (! $this->appId || ! $this->appCode) {
            throw new HereApiException('AppId or AppCode missing.');
        }
    }

    /**
     * Convert the given response to a Collection.
     *
     * @param  mixed  $data
     * @param  mixed|null  $index
     */
    private function convertToCollection($data, $index = null): Collection
    {
        $data = collect($data);

        return $index ? collect(data_get($data, $index)) : $data;
    }
}
