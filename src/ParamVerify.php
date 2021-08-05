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
     *
     * @var array
     */
    protected $settings = [];

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
        $this->settings = $settings;
        $this->required = $this->getRequired($settings);
    }

    /**
     * @inheritDoc
     */
    public function verify(array $values, ?array $settings = null): array
    {
        $errors = [];

        $intersect = array_intersect_key($this->required, $values);
        if (count($this->required) !== count($intersect)) {
            $errors[] = sprintf('Required values [%s] are missing from the parameters.', implode(' ', array_keys($intersect)));
        }

        // Choose which group of settings to use, configured or supplied.
        $settings = $settings ?? $this->settings;

        foreach ($values as $key => $value) {
            if (!empty($settings[$key])) {
                $this->verifyValue($key, $value, $errors, $settings);
            }
        }

        return $errors;
    }

    /**
     * @inheritDoc
     */
    public function verifyValue(string $key, $value, array &$errors, ?array $settings = null): void
    {
        // Choose which group of settings to use, configured or supplied.
        $settings = $settings[$key] ?? $this->settings[$key];
        $range = $settings['range'] ?? false;

        switch ($settings['type']) {
            case '*':
                $fail = false;
                break;
            case 'null':
                $fail = !is_null($value);
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
                if (!$fail && $range) {
                    if (!empty($range['min_value'])) {
                        $fail = strlen($value) < $range['min_value'];
                    }
                    if (!empty($range['max_value'])) {
                        $fail = strlen($value) > $range['max_value'];
                    }
                }
                break;
            case 'bool':
                $fail = !is_bool($value);
                break;
            case 'float':
                $fail = !is_float($value);
                if (!$fail && $range) {
                    if (!empty($range['min_value'])) {
                        $fail = strlen($value) < $range['min_value'];
                    }
                    if (!empty($range['max_value'])) {
                        $fail = strlen($value) > $range['max_value'];
                    }
                }
                break;
            case 'string':
                $fail = !is_string($value);
                if (!$fail && $range) {
                    if (!empty($range['min_length'])) {
                        $fail = strlen($value) < $range['min_length'];
                    }
                    if (!empty($range['max_length'])) {
                        $fail = strlen($value) > $range['max_length'];
                    }
                }
                break;
            case 'enum':
                $fail = !is_string($value);
                if (!$fail) {
                    $items = explode('|', $settings['data']);
                    $fail = !in_array($value, $items);
                }
                break;
            case 'regex':
                $fail = !(is_string($value) && preg_match($settings['data'], $value));
                break;
            case 'callable':
                $fail = !is_callable($value);
                break;
            case 'resource':
                $fail = !is_resource($value);
                break;
            default:
                $fail = TRUE;
                break;
        }
        if ($fail) {
            $errors[] = sprintf('Key "%s", value "%s" is not type "%s", it is type "%s"', $key, $value, $settings['type'], gettype($value));
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