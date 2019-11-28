<?php

namespace App\Services\Location;

use App\Location\Here\HereApi;
use App\Services\Meal\Exceptions\InvalidLocationId;
use App\Services\Meal\Exceptions\InvalidCustomAddress;
use PerfectOblivion\Services\Traits\SelfCallingService;

class GeocodeService
{
    use SelfCallingService;

    /** @var \App\Location\Here\HereApi */
    private $here;

    /**
     * Construct a new GeocodeService.
     *
     * @param  \App\Location\Here\HereApi  $here
     */
    public function __construct(HereApi $here)
    {
        $this->here = $here;
    }

    /**
     * Handle the call to the service.
     *
     * @param  string  $method
     * @param  array  $options
     *
     * @return mixed
     */
    public function run(string $method, array $options)
    {
        return $this->{$method}($options);
    }

    /**
     * Get the location coordinates from the given location data.
     *
     * @param  array  $locationData
     */
    private function geocode(array $locationData): string
    {
        if ($locationData['customLocationId']) {
            return $this->geocodeFromLocationId($locationData['customLocationId']);
        }
        if ($locationData['customLocationAddress']) {
            return $this->geocodeFromAddress($locationData['customLocationAddress']);
        }

        return $this->normalizeCoordinates($locationData['currentLocation']);

    }

    /**
     * Get custom coordinates from the location id.
     *
     * @param  string  $locationId
     */
    private function geocodeFromLocationId(string $locationId): string
    {
        $coords = $this->here->geocodeFromLocationid($locationId);
        if (! $coords) {
            throw InvalidLocationId::fromLocationId();
        }

        return implode(',', $coords);
    }

    /**
     * Get custom coordinates from the location address.
     *
     * @param  string  $locationAddress
     */
    private function geocodeFromAddress(string $locationAddress): string
    {
        $coords = $this->here->geocodeFromLocationAddress($locationAddress);
        if (! $coords) {
            throw InvalidCustomAddress::fromAddress($locationAddress);
        }

        return implode(',', $coords);
    }

    /**
     * Get current coordinates from the location data.
     *
     * @param  array  $locationData
     */
    private function normalizeCoordinates(string $coordinates): string
    {
        return preg_replace('/\s/', '', $coordinates);
    }
}
