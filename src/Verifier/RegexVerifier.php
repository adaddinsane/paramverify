<?php

namespace ParamVerify\Verifier;

use ParamVerify\ParamVerifyException;
use ParamVerify\VerifierBase;

class RegexVerifier extends VerifierBase
{

    /**
     * @inheritDoc
     */
    protected function dataCheck(?string $data): string
    {
        if (empty($data)) {
            throw new ParamVerifyException(sprintf('Regex verifier "%s" has no regex defined.', $this->name));
        }

        if (@preg_match($data, null) === false) {
            throw new ParamVerifyException(sprintf('Supplied regex for verifier "%s" is not valid.', $this->name));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_string($value) && preg_match($this->data, $value);
    }
}