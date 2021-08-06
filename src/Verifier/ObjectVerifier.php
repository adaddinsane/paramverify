<?php

namespace ParamVerify\Verifier;

use ParamVerify\VerifierBase;

class ObjectVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_object($value);
    }
}