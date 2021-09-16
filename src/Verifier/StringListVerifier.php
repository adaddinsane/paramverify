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
        if (!is_string($value)) {
            return false;
        }

        if (!in_array($value, $this->items)) {
            $allowed = implode(' | ', $this->items);
            $errors[] = sprintf('Value (%s) for %s is not one of the allowed values (%s)', $value, $this->name, $allowed);
        }

        // Even if the validation fails, we don't want a "bad type" message here.
        return true;
    }
}