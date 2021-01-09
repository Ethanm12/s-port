<?php

namespace App\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    public function __construct($pageName)
    {
        $this->code = 404;
        $this->message = "Page \"{$pageName}\" not found.";
    }
}