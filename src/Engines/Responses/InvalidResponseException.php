<?php

namespace AIStation\Engines\Responses;

class InvalidResponseException extends \Exception
{
    public function __construct($message = "Got an invalid response from the API. Please check your API Server logs for more details.")
    {
        parent::__construct($message);
    }
}
