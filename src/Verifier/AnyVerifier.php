<?php

namespace ParamVerify\Verifier;

use ParamVerify\VerifierBase;

class AnyVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return true;
    }
}