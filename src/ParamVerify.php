<?php

namespace Adaddinsane\ParamVerify;

/**
 * Class ParamVerify.
 *
 * @author Steve Turnbull
 */
class ParamVerify implements ParamVerifyInterface
{
    /**
     * The verifiers to be applied to a set of parameters.
     *
     * @var VerifierInterface[]
     */
    protected $verifiers = [];

    /**
     * The required parameters from the settings.
     *
     * @var array
     */
    protected $required = [];

    /**
     * Constructor ParamVerify
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->verifiers = $this->generateSettings($settings);
        $this->required = $this->getRequired($this->verifiers);
    }

    /**
     * Given the array structure of the settings, return all the verifiers.
     *
     * Exceptions may be thrown, but we don't want to catch them because
     * an error at this point means the code is wrong.
     *
     * @param array $settings
     *
     * @return VerifierInterface[]
     */
    protected function generateSettings(array $settings): array {
        $verifiers = [];
        foreach ($settings as $name => $setting) {
            $setting += static::DEFAULT_PARAM_CONFIG;
            $classBase = $this->makeClassName($setting['type']) . 'Verifier';
            $class = "\Adaddinsane\ParamVerify\Verifier\\{$classBase}";
            $verifiers[$name] = new $class($name, $setting);
        }
        return $verifiers;
    }

    /**
     * Get an array keyed by all the settings that must be present.
     *
     * @param array $settings
     *
     * @return array
     */
    protected function getRequired(array $settings): array
    {
        $required = [];

        array_walk($settings, function (VerifierInterface $verifier, $key) use (&$required) {
            $required[$key] = $verifier->isRequired();
        });

        return array_filter($required);
    }

    /**
     * Converts snake_case to CamelCase.
     *
     * @param string $name
     *
     * @return string
     */
    protected function makeClassName(string $name): string {
        return str_replace(' ', '', ucwords(mb_strtolower(str_replace(['-', '_'], ' ', $name))));
    }

    /**
     * @inheritDoc
     */
    public function verify(array $values, array &$errors = []): void
    {
        $intersect = array_intersect_key($this->required, $values);
        if (count($this->required) !== count($intersect)) {
            // Which required values were not supplied?
            $nonIntersect = array_diff_key($this->required, $intersect);
            $errors[] = sprintf('Required value(s) [%s] are missing from the supplied parameters.',
                implode(', ', array_keys($nonIntersect)));
        }

        foreach ($values as $key => $value) {
            if (!empty($this->verifiers[$key])) {
                $this->verifyValue($value, $this->verifiers[$key], $errors);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function verifyValue($value, VerifierInterface $verifier, array &$errors): void
    {
        if (!$verifier->verify($value, $errors)) {
            // The verify function did not provide its own errors.
            $errors[] = sprintf('Key "%s", value "%s" is not type "%s", it is type "%s"',
              $verifier->getName(),
              is_scalar($value) ? $value : gettype($value),
              $verifier->getType(),
              gettype($value)
            );
        }
    }

}
