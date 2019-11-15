<?php

namespace App\Http\Actions\Location;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Location\AutocompleteLocationService;
use App\Http\Responders\Location\AutocompleteLocationResponder;

class AutocompleteLocation extends Action
{
    /** @var \App\Http\Responders\Location\AutocompleteLocationResponder */
    private $responder;

    /**
    * Construct a new AutocompleteLocation action.
    *
    * @param  \App\Http\Responders\Location\AutocompleteLocationResponder  $responder
    */
    public function __construct(AutocompleteLocationResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        $results = AutocompleteLocationService::call($request->get('search'));

        return $this->responder->withPayload($results)->respond();
    }
}
