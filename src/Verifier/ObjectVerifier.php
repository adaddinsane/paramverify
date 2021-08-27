<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;

class ObjectVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        return is_object($value);
    }
}