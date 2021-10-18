<?php

namespace App\Exceptions;

use Exception;

class PredictionNotPossibleException extends Exception
{
    public function __construct($reason) {
        parent::__construct('It\'s not possible to make a prediction: '.$reason);
    }
}
