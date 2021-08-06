<?php

namespace ParamVerify\Verifier;

use ParamVerify\ParamVerifyException;
use ParamVerify\VerifierBase;

class IntVerifier extends VerifierBase
{
    protected static $ranges = ['min_value', 'max_value'];

    /**
     * @inheritDoc
     */
    protected function rangeCheck(?array $range): array
    {
        $range = $range ?? [];

        if ($range !== null) {
            foreach ($range as $key => $value) {
                if (!in_array($key, static::$ranges)) {
                    throw new ParamVerifyException(sprintf('Illegal range %s in %s IntVerifier', $key, $this->name));
                }
                if (!is_int($value)) {
                    throw new ParamVerifyException(sprintf('Illegal range value %s for %s in %s IntVerifier', $value, $key, $this->name));
                }
            }
        }

        return $range;
    }

    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        $success = is_int($value);

        if ($success && $this->range) {
            if (!empty($range['min_value'])) {
                $success = $value >= $range['min_value'];
            }
            if (!empty($range['max_value'])) {
                $success = $value <= $range['max_value'];
            }
        }

        return $success;
    }
}