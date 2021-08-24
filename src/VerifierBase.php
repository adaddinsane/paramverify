<?php

namespace Adaddinsane\ParamVerify;

abstract class VerifierBase implements VerifierInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $required;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var array
     */
    protected $range;

    /**
     * Constructor for VerifierBase.
     *
     * @param string $name
     * @param array $options
     *
     * @throws ParamVerifyException
     */
    public function __construct(string $name, array $options)
    {
        $this->name = $name;
        $this->type = $options['type'];
        $this->required = $options['required'] ?? false;
        $this->data = $this->dataCheck($options['data']);
        $this->range = $this->rangeCheck($options['range']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Overridable function to check a proper data value for the verifier.
     *
     * @param string|null $data
     *
     * @return string
     *
     * @throws ParamVerifyException
     */
    protected function dataCheck(?string $data): string
    {
        return $data ?? '';
    }

    /**
     * Overridable function to check a proper range value for the verifier.
     *
     * @param array|null $range
     *
     * @return array
     *
     * @throws ParamVerifyException
     */
    protected function rangeCheck(?array $range): array
    {
        return $range ?? [];
    }
}