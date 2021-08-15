<?php

namespace ParamVerify;

class ParamVerifyFactory implements ParamVerifyFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function make(array $settings): ParamVerifyInterface
    {
        // We make sure the supplied settings
        $checker = new ParamVerify(static::VERIFY);
        $errors = $checker->verify($settings);
        if (!empty($errors)) {
            throw new ParamVerifyException('Bad settings for ParamVerify provided.', 0, null, $errors);
        }

        return new ParamVerify($settings);
    }
}