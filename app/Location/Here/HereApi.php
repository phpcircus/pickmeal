<?php

namespace App\Location\Here;

use App\Location\AbstractLocation;

class HereApi extends AbstractLocation
{
    const PLACES_BASE_URL = 'https://places.api.here.com/places/v1/';

    const BROWSE_PATH = 'browse';

    const LOOKUP_PATH = 'places';

    const AUTOCOMPLETE_URL = 'http://autocomplete.geocoder.api.here.com/6.2/suggest.json';

    const GEOCODE_URL = 'http://geocoder.api.here.com/6.2/geocode.json';

    /** @var array */
    protected $credentials = [
        'app_id' => null,
        'app_code' => null,
    ];

    /**
     * Search for places in the given radius for the given location, using the given options.
     *
     * @param  array  $options
     *
     * @return \Illuminate\Support\Collection
     */
    public function search(array $options)
    {
        $response = $this->makeRequest(self::PLACES_BASE_URL.self::BROWSE_PATH, $options);

        return $this->convertToCollection($response, 'results.items');
    }

    /**
     * Lookup a place given the place id from a search request.
     *
     * @param  string  $id
     */
    public function lookup(string $id): array
    {
        return $this->makeRequest(self::PLACES_BASE_URL.self::LOOKUP_PATH.'/'.$id);
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
        $response = $this->makeRequest(self::AUTOCOMPLETE_URL, ['query' => $search, 'maxresults' => 3]);

        return $this->convertToCollection($response, 'suggestions');
    }

    /**
     * Geocode a location based on the given locationId.
     */
    public function geocodeFromLocationId(string $locationId): array
    {
        $response = $this->makeRequest(self::GEOCODE_URL, [
            'locationId' => $locationId,
            'jsonattributes' => 1,
            'gen' => 9,
        ]);

        return $response['response']['view'][0]['result'][0]['location']['navigationPosition'][0];
    }

    /**
     * Geocode a location based on the given locationAddress.
     */
    public function geocodeFromLocationAddress(string $locationAddress): array
    {
        $response = $this->makeRequest(self::GEOCODE_URL, [
            'searchtext' => $locationAddress,
            'jsonattributes' => 1,
            'gen' => 9,
        ]);

        if (! count($response['response']['view']) > 0) {
            return [];
        }

        return $response['response']['view'][0]['result'][0]['location']['navigationPosition'][0];
    }
}
