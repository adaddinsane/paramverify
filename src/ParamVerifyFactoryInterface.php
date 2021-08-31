<?php

namespace Adaddinsane\ParamVerify;

interface ParamVerifyFactoryInterface
{

    const VERIFY = [
        'required' => [
            'required' => false,
            'type' => 'int_bool'
        ],
        'type' => [
            'required' => true,
            'type' => 'string_list',
            'data' => 'any|null|class|object|array|int|bool|int_bool|float|string|string_list|regex|callable|resource|url|email|enum'
        ],
      'settings' => [
        'required' => false,
        'type' => 'array'
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
     * Create a ParamVerify object using the given configuration.
     *
     * @param array $configuration
     *
     * @return ParamVerifyInterface
     *
     * @throws ParamVerifyException
     */
    public function make(array $configuration): ParamVerifyInterface;

}
