<?php

namespace ParamVerify\Verifier;

use ParamVerify\ParamVerifyException;
use ParamVerify\VerifierBase;

class StringVerifier extends VerifierBase
{
    protected static $ranges = ['min_length', 'max_length'];

    /**
     * @inheritDoc
     */
    protected function rangeCheck(?array $range): array
    {
        $range = $range ?? [];

        if ($range !== null) {
            foreach ($range as $key => $value) {
                if (!in_array($key, static::$ranges)) {
                    throw new ParamVerifyException(sprintf('Illegal range %s in %s StringVerifier', $key, $this->name));
                }
                if (!is_int($value) || $value < 0) {
                    throw new ParamVerifyException(sprintf('Illegal range value %s for %s in %s StringVerifier', $value, $key, $this->name));
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
        $success = is_string($value);

        if ($success && $this->range) {
            if (!empty($range['min_length'])) {
                $success = strlen($value) >= $range['min_length'];
            }
            if (!empty($range['max_length'])) {
                $success = strlen($value) <= $range['max_length'];
            }
        }
        return $success;
    }
}