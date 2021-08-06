<?php

namespace ParamVerify\Verifier;

use ParamVerify\ParamVerifyException;

class ClassVerifier extends VerifierBase
{
    /**
     * @inheritDoc
     */
    protected function dataCheck(?string $data): string
    {
        if (empty($data)) {
            throw new ParamVerifyException(sprintf('Class verifier "%s" has no class defined.', $this->name));
        }

        if (!class_exists($data)) {
            throw new ParamVerifyException(sprintf('Class verifier "%s" class "%s" does not exist.', $this->name, $data));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        return is_a($value, $this->data);
    }
}