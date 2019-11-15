<?php

namespace App\Services\Location;

use App\Here\HereApi;
use PerfectOblivion\Services\Traits\SelfCallingService;

class AutocompleteLocationService
{
    use SelfCallingService;

    /** @var \App\Here\HereApi */
    private $api;

    /**
     * Construct a new AutocompleteLocationService.
     *
     * @param  App\Here\HereApi  $api
     */
    public function __construct(HereApi $api)
    {
        $this->api = $api;
    }

    /**
     * Handle the call to the service.
     *
     * @param  string  $search
     *
     * @return mixed
     */
    public function run(?string $search = '')
    {
        return $this->api->autosuggest($search);
    }
}
