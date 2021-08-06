<?php

namespace ParamVerify\Verifier;

use ParamVerify\VerifierBase;

class ResourceVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_resource($value);
    }
}