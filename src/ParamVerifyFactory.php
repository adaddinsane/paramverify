<?php

namespace Adaddinsane\ParamVerify;

class ParamVerifyFactory implements ParamVerifyFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function make(array $configuration): ParamVerifyInterface
    {
        // We make sure the supplied $configuration is the correct structure.
        $checker = new ParamVerify(static::VERIFY);

        $errors = [];
        foreach ($configuration as $settings) {
          $checker->verify($settings, $errors);
        }
      if (!empty($errors)) {
        throw new ParamVerifyException('Bad settings for ParamVerify provided.', 0, NULL, $errors);
      }

        return new ParamVerify($configuration);
    }
}
