<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;

class CallableVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        return is_callable($value);
    }
}