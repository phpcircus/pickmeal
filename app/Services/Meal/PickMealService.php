<?php

namespace App\Services\Meal;

use App\Here\HereApi;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Services\Meal\Exceptions\InvalidLocationId;
use App\Services\Meal\Exceptions\InvalidCustomAddress;
use PerfectOblivion\Services\Traits\SelfCallingService;

class PickMealService
{
    use SelfCallingService;

    /** @var \App\Here\HereApi */
    private $here;

    /** @var \App\Services\Meal\PickMealValidationService */
    private $validator;

    /**
     * Construct a new PickMealService.
     *
     * @param  \App\Here\HereApi  $here
     * @param  \App\Services\Meal\PickMealValidationService  $validator
     */
    public function __construct(HereApi $here, PickMealValidationService $validator)
    {
        $this->here = $here;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $options
     *
     * @return mixed
     */
    public function run(array $options)
    {
        $this->validator->validate($options);

        $optimizedOptions = $this->getOptimizedOptions($options);
        $searchResults = $this->here->search($optimizedOptions);
        $numberOfResults = $this->getNumberOfResults($options['numberOfResults'], $searchResults->count());

        $restaurants = $this->optimizeResults($searchResults, $numberOfResults);

        return $this->getResultData($restaurants);
    }

    /**
     * Get the optimized options for the search request.
     *
     * @param  array  $options
     */
    private function getOptimizedOptions(array $options): array
    {
        $coordinates = $this->getCoordinates(Arr::only($options, ['customLocationId', 'customLocationAddress', 'currentLocation']));
        $radius = (int) round(($options['searchRadius'] * 1609.344), 0, PHP_ROUND_HALF_UP);
        $category = $this->getCategory($options['price']);

        return [
            'in' => $coordinates.'; r='.$radius,
            'cat' => $category,
            'cs' => 'pds',
        ];
    }

    /**
     * Get the location coordinates from the given location data.
     *
     * @param  array  $locationData
     */
    private function getCoordinates(array $locationData): string
    {
        if ($locationData['customLocationId']) {
            return $this->getCustomCoordinatesFromLocationId($locationData['customLocationId']);
        }
        if ($locationData['customLocationAddress']) {
            return $this->getCustomCoordinatesFromLocationAddress($locationData['customLocationAddress']);
        }

        return $this->getCurrentCoordinates($locationData);

    }

    /**
     * Get custom coordinates from the location id.
     *
     * @param  string  $locationId
     */
    private function getCustomCoordinatesFromLocationId(string $locationId): string
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
    private function getCustomCoordinatesFromLocationAddress(string $locationAddress): string
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
    private function getCurrentCoordinates(array $locationData): string
    {
        return preg_replace('/\s/', '', $locationData['currentLocation']);
    }

    /**
     * Get the search category based on the given price level.
     *
     * @param  int  $price
     */
    private function getCategory($price): string
    {
        $category = '';

        if ($price === 1) {
            $category = config('here.categories')['fast-food'];
        } elseif ($price === 2) {
            $category = config('here.categories')['casual'];
        } elseif ($price === 3) {
            $category = config('here.categories')['fine'];
        }

        return $category;
    }

    /**
     * Determine how many random results will be returned.
     *
     * @param  int  $requested
     * @param  int  $total
     */
    private function getNumberOfResults(int $requested, int $total): int
    {
        if ($requested > $total) {
            return $total;
        }

        return $requested;
    }

    /**
     * Optimize the search results.
     */
    private function optimizeResults(Collection $results, int $numberOfResults): Collection
    {
        if ($results->count() > 0) {
            $randomResults = $results->random($numberOfResults);

            if ($randomResults instanceof Collection) {
                return $randomResults;
            }

            if (is_array($randomResults)) {
                return collect($randomResults);
            }

             return collect(Arr::wrap($randomResults));
        }

        return collect([]);
    }

    /**
     * Get the final results.
     *
     * @param  \Illuminate\Support\Collection  $restaurants
     */
    private function getResultData(Collection $restaurants): Collection
    {
        return $restaurants->map(function($restaurant) {
            return [
                'title' => $restaurant['title'],
                'address' => str_replace(['<br>', '<br/>'], ' ', $restaurant['vicinity']),
                'share' => $this->getShareableLink($restaurant['href']),
            ];
        });
    }

    /**
     * Get a shareable link for the restaurant.
     *
     * @param  string  $href
     */
    private function getShareableLink(string $href): string
    {
        $identifier = Str::after(Str::before($href, '?app_id'), '/places/v1/places/');

        return $this->here->lookup($identifier)['view'];
    }
}
