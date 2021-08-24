<?php

namespace Adaddinsane\ParamVerify;

use Exception;
use Throwable;

class ParamVerifyException extends Exception
{

    /**
     * @var array
     */
    protected $errors;

    /**
     *
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param array $errors
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, array $errors = [])
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}