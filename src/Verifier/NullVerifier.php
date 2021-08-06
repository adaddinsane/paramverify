<?php

namespace ParamVerify\Verifier;

use ParamVerify\VerifierBase;

class NullVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_null($value);
    }
}