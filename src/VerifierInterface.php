<?php

namespace Adaddinsane\ParamVerify;

interface VerifierInterface
{

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * Test this value against this verifier.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function verify($value): bool;

}