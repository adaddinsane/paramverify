<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class EmailVerifier extends VerifierBase
{

    /**
     * @inheritDoc
     */
    public function verify($value): bool
    {
        $success = is_string($value);

        if ($success) {
            $validator = new EmailValidator();
            $success = $validator->isValid($value, new RFCValidation());
        }

        return $success;
    }
}