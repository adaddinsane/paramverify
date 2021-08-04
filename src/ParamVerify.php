<?php

namespace ParamVerify;

/**
 * Class ParamVerify.
 *
 * @author Steve Turnbull
 */
class ParamVerify implements ParamVerifyInterface
{
    /**
     * The settings to be applied to a set of parameters.
     */
    protected array $settings = [];

    /**
     * The required parameters from the settings.
     */
    protected array $required = [];

    /**
     * Constructor ParamVerify
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
        $this->required = $this->getRequired($settings);
    }

    /**
     * @inheritDoc
     */
    public function verify(array $values): array
    {
        $errors = [];

        $intersect = array_intersect_key($this->required, $values);
        if (count($this->required) !== count($intersect)) {
            $errors[] = sprintf('Required values [%s] are missing from the parameters.', implode(' ', array_keys($intersect)));
        }

        foreach ($values as $key => $value) {
            if (!empty($this->settings[$key])) {
                $this->verifyValue($key, $value, $errors);
            }
        }

        return $errors;
    }

    /**
     * @inheritDoc
     */
    public function verifyValue(string $key, $value, array &$errors): void
    {
        $settings = $this->settings[$key];

        switch ($settings['type']) {
            case '*':
                $fail = false;
                break;
            case 'class':
                $fail = !is_a($value, $settings['data']);
                break;
            case 'object':
                $fail = !is_object($value);
                break;
            case 'array':
                $fail = !is_array($value);
                break;
            case 'int':
                $fail = !is_int($value);
                break;
            case 'bool':
                $fail = !is_bool($value);
                break;
            case 'float':
                $fail = !is_float($value);
                break;
            case 'string':
                $fail = !is_string($value);
                break;
            case 'regex':
                $fail = !is_string($value) || !preg_match($settings['data'], $value);
                break;
            default:
                $fail = TRUE;
                break;
        }
        if ($fail) {
            $errors[] = sprintf('Value "%s" is not type "%s", it is type "%s"', $value, $settings['type'], gettype($value));
        }
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

        array_walk($settings, function ($item, $key) use (&$required) {
            $required[$key] = !empty($item['required']);
        });

        return array_filter($required);
    }

}