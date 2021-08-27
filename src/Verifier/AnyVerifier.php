<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;

class AnyVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        return true;
    }
}