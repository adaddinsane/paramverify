<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;

class ArrayVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        return is_array($value);
    }
}