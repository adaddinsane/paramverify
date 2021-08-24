<?php

namespace Adaddinsane\ParamVerify;

interface ParamVerifyFactoryInterface
{

    const VERIFY = [
        'required' => [
            'required' => false,
            'type' => 'bool'
        ],
        'type' => [
            'required' => true,
            'type' => 'string_list',
            'data' => 'any|null|class|object|array|int|bool|float|string|string_list|regex|callable|resource|enum'
        ],
        'data' => [
            'required' => false,
            'type' => 'string'
        ],
        'range' => [
            'required' => false,
            'type' => 'array'
        ]
    ];

    /**
     * Create a ParamVerify object using the given settings.
     *
     * @param array $settings
     *
     * @return ParamVerifyInterface
     *
     * @throws ParamVerifyException
     */
    public function make(array $settings): ParamVerifyInterface;

}