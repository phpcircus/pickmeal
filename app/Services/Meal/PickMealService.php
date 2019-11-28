<?php

namespace App\Services\Meal;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Location\Here\HereApi;
use Illuminate\Support\Collection;
use App\Services\Location\GeocodeService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class PickMealService
{
    use SelfCallingService;

    /** @var \App\Location\Here\HereApi */
    private $here;

    /** @var \App\Services\Meal\PickMealValidationService */
    private $validator;

    /**
     * Construct a new PickMealService.
     *
     * @param  \App\Location\Here\HereApi  $here
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
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function run(array $parameters)
    {
        $this->validator->validate($parameters);
        $searchResults = $this->here->search($this->normalizeParameters($parameters));

        return $this->getRestaurants($searchResults, $parameters['maxResults']);
    }

    /**
     * Get the optimized options for the search request.
     *
     * @param  array  $parameters
     */
    private function normalizeParameters(array $parameters): array
    {
        $coordinates = GeocodeService::call(
            'geocode',
            Arr::only($parameters, ['customLocationId', 'customLocationAddress', 'currentLocation']),
        );
        $radius = $this->convertMilesToMeters($parameters['searchRadius']);
        $category = $this->getCategory($parameters['level']);

        return [
            'in' => $coordinates.'; r='.$radius,
            'cat' => $category,
            'cs' => 'pds',
            'size' => 50,
        ];
    }

    /**
     * Get the search category based on the given price level.
     *
     * @param  int  $level
     */
    private function getCategory($level): string
    {
        return collect(config('here.categories'))->filter(function ($value, $category) use ($level) {
            return $value === $level;
        })->first();
    }

    /**
     * Convert the given miles to meters.
     *
     * @param  int  $meters
     */
    private function convertMilesToMeters(int $meters): int
    {
        return (int) round(($meters * 1609.344), 0, PHP_ROUND_HALF_UP);
    }

    /**
     * Get the final results.
     *
     * @param  \Illuminate\Support\Collection  $results
     */
    private function getRestaurants(Collection $results, int $maxResults): Collection
    {
        $restaurants = collect([]);

        if ($results->count() > 0) {
            $randomResults = $results->random($maxResults);
            if ($randomResults instanceof Collection) {
                $restaurants = $randomResults;
            }elseif (is_array($randomResults)) {
                $restaurants = collect($randomResults);
            }else {
                $restaurants = collect(Arr::wrap($randomResults));
            }
        }

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
