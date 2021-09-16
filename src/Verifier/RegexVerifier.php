<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\ParamVerifyException;
use Adaddinsane\ParamVerify\VerifierBase;

class RegexVerifier extends VerifierBase
{

    /**
     * @inheritDoc
     */
    protected function dataCheck(string $data): string
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
    public function verify($value, array &$errors = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (!preg_match($this->data, $value)) {
            $errors[] = sprintf('Value (%s) for %s does not match the supplied regex', $value, $this->name);
        }

        // Even if the validation fails, we don't want a "bad type" message here.
        return true;
    }
}