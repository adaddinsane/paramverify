<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\VerifierBase;
use Riimu\Kit\UrlParser\UriParser;

class UrlVerifier extends VerifierBase
{

    /**
     * @inheritDoc
     */
    public function verify($value, array &$errors = []): bool
    {
        if (!is_string($value)) {
          return false;
        }

        $parser = new UriParser();
        $parsed = $parser->parse($value);
        if ($parser->parse($value) === null) {
          $errors[] = sprintf('Url value (%s) for %s is not valid', $value, $this->name);
        }

        // Even if the validation fails, we don't want a type message here.
        return true;
    }
}