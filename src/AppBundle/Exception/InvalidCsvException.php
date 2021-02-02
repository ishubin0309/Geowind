<?php

namespace AppBundle\Exception;

/**
 * InvalidCsvException
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class InvalidCsvException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
