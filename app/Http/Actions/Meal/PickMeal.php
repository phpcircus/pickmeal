<?php

namespace App\Http\Actions\Meal;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Meal\PickMealService;
use App\Http\Responders\Meal\PickMealResponder;

class PickMeal extends Action
{
    /** @var \App\Http\Responders\Meal\PickMealResponder */
    private $responder;

    /**
    * Construct a new PickMeal action.
    *
    * @param  \App\Http\Responders\Meal\PickMealResponder  $responder
    */
    public function __construct(PickMealResponder $responder)
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
        $result = PickMealService::call($request->get('search'));

        return $this->responder->withPayload($result)->respond();
    }
}
