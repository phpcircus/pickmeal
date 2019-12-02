<?php

namespace App\Http\Responders\Location;

use PerfectOblivion\Responder\Responder;

class AutocompleteLocationResponder extends Responder
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
                'autocomplete' => $this->payload,
            ], 200);
        }

        $this->request->session()->flash('autocomplete', $this->payload);

        return redirect()->route('home');
    }
}
