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
        $success = is_string($value);

        if ($success) {
            $parser = new UriParser();
            $parsed = $parser->parse($value);
            $success = $parsed !== null;
        }

        return $success;
    }
}