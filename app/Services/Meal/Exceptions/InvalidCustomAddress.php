<?php

namespace App\Services\Meal\Exceptions;

use Exception;

class InvalidCustomAddress extends Exception
{
    /**
     * Build exception for InvalidCustomAddress from a given address.
     */
    public static function fromAddress($address): InvalidCustomAddress
    {
        return new self(`Unable to retrieve coordinates for the given address: {$address}`);
    }
}
