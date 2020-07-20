<?php

namespace LiveStream\Exceptions;

use Exception;

class InValidResourceException extends Exception
{
    public function __construct(string $resource, string $field) {
        parent::__construct("'$field' field on '$resource' resource not set ", 0, null);
    }
}