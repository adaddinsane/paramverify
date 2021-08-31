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
    public function verify($value, array &$errors = []): bool
    {
        if (!is_string($value)) {
          return false;
        }

        $validator = new EmailValidator();
        if (!$validator->isValid($value, new RFCValidation())) {
          $errors[] = sprintf('Email value (%s) for %s is not valid', $value, $this->name);
        }

        // Even if the validation fails, we don't want a type message here.
        return true;
    }
}