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
        $this->request->session()->flash('autocomplete', $this->payload);

        return redirect()->route('dashboard');
    }
}
