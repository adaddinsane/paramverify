<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;

class IntBoolVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_bool($value) || in_array($value, [0, 1], true);
    }
}