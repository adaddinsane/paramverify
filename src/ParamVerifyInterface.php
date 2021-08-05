<?php

namespace ParamVerify;

/**
 * Interface ParamVerifyInterface
 *
 * @author Steve Turnbull
 */
interface ParamVerifyInterface
{
    /**
     * This is the default configuration the values are as follows:
     * 'required'
     *     Indicates whether this parameter is required or not,
     *     no error is generated if it's not required and missing,
     *     but if present it must match the other specifications.
     *
     * 'type'
     *     The type of the parameter value:
     *     string, regex, bool, int, float, array, object, class, enum, resource, callable, null or "*"
     *
     * 'data'
     *     This may be omitted or null, unless the 'type' is:
     *     - 'regex' data must contain the regex field,
     *     - 'class' this is a fully qualified class/interface name,
     *     - 'enum' this is a set of string values with '|' as the divider.
     *
     * 'range'
     *     This may be omitted or null, it may be included as an array for:
     *     - 'string' it can have min_length and max_length values.
     *     - 'int' it can have min_value and max_value values.
     *     - 'float' it can have min_value and max_value values.
     */
    public const DEFAULT_PARAM_CONFIG = [
        'required' => false,
        'type' => 'string',
        'data' => null,
        'range' => null
    ];

    /**
     * Process the supplied values are return an array of results.
     *
     * Any invalid or missing values are flagged in this array, so
     * if it's empty then everything is fine.
     *
     * @param array $values
     *   The values to be checked.
     * @param array|null $settings
     *   Allows us to apply arbitrary, not configured settings
     *
     * @return array
     *   The array of errors (empty = none).
     */
    public function verify(array $values, ?array $settings = null): array;

    /**
     * Check a value against the supplied settings.
     *
     * If there's an error it is added as a string to the errors array.
     *
     * @param string $key
     *   The key of the value to be checked.
     * @param mixed $value
     *   The value to be checked.
     * @param array $errors
     *   A list of errors to be added to.
     * @param array|null $settings
     *   Allows us to apply arbitrary, not configured settings
     */
    public function verifyValue(string $key, $value, array &$errors, ?array $settings = null): void;

}