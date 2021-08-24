<?php

namespace Adaddinsane\ParamVerify\Verifier;

use ParamVerify\ParamVerifyException;

class EnumVerifier extends ClassVerifier
{
    /**
     * @inheritDoc
     */
    protected function dataCheck(?string $data): string
    {
        if (empty($data)) {
            throw new ParamVerifyException(sprintf('Enum verifier "%s" has no enum defined.', $this->name));
        }

        if (!enum_exists($data)) {
            throw new ParamVerifyException(sprintf('Enum verifier "%s" enum "%s" does not exist.', $this->name, $data));
        }

        return $data;
    }
}