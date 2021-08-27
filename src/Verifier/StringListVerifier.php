<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\ParamVerifyException;
use Adaddinsane\ParamVerify\VerifierBase;

class StringListVerifier extends VerifierBase
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @inheritDoc
     */
    protected function dataCheck(string $data): string
    {
        if (empty($data)) {
            throw new ParamVerifyException(sprintf('List verifier "%s" has no list defined.', $this->name));
        }

        $this->items = explode('|', $data);

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        return is_string($value) && in_array($value, $this->items);
    }
}