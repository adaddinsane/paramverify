<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\ParamVerify;
use Adaddinsane\ParamVerify\ParamVerifyFactory;
use Adaddinsane\ParamVerify\VerifierBase;

class ArrayVerifier extends VerifierBase
{

    /**
     * The verifiers for this array.
     *
     * @var ParamVerify
     */
    protected $subParamVerify;

    /**
     * @inheritDoc
     */
    protected function settingsCheck(array $settings): array {
        if (!empty($settings)) {
            // If there are no settings we leave this empty.
            $this->subParamVerify = (new ParamVerifyFactory())->make($settings);
        }

        return $settings;
    }

    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        if (!is_array($value)) {
            return false;
        }

        if ($this->subParamVerify) {
            $this->subParamVerify->verify($value, $errors);
        }

        // There might be errors, but we return true here to prevent a
        // message claiming this array is not an array (because it is).
        return true;
    }
}