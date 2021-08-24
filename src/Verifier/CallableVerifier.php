<?php

namespace Adaddinsane\ParamVerify\Verifier;

class CallableVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_callable($value);
    }
}