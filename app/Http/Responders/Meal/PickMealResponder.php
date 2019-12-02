<?php

namespace App\Http\Responders\Meal;

use PerfectOblivion\Responder\Responder;

class PickMealResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        if ($this->request->isApi()) {
            return response()->json([
                'restaurants' => $this->payload,
            ], 200);
        }

        $this->request->session()->flash('restaurants', $this->payload);
        $this->request->session()->flash('show_restaurant_modal', true);

        return redirect()->route('home');
    }
}
