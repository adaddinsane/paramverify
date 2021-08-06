<?php

namespace ParamVerify\Verifier;

class ArrayVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_array($value);
    }
}