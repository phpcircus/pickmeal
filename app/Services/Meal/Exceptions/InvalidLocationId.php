<?php

namespace App\Services\Meal\Exceptions;

use Exception;

class InvalidLocationId extends Exception
{
    /**
     * Build exception for InvalidLocationId from a given address.
     */
    public static function fromLocationId(): InvalidLocationId
    {
        return new self('Unable to retrieve coordinates for the chosen location.');
    }
}
