<?php

namespace Adaddinsane\ParamVerify\Verifier;

use Adaddinsane\ParamVerify\ParamVerify;
use Adaddinsane\ParamVerify\ParamVerifyException;
use Adaddinsane\ParamVerify\ParamVerifyFactory;
use Adaddinsane\ParamVerify\ParamVerifyFactoryInterface;
use Adaddinsane\ParamVerify\VerifierBase;
use Drupal\be_worldpay\Exception\BadServiceValueException;

class CollectionVerifier extends VerifierBase
{

  /**
   * The verifiers for this collection.
   *
   * @var ParamVerify
   */
    protected $subParamVerify;

  /**
   * @inheritDoc
   */
    protected function settingsCheck(array $settings): array {
      $this->subParamVerify = (new ParamVerifyFactory())->make($settings);

      return $settings;
    }

  /**
     * @inheritDoc
     */
    public function verify($values, array &$errors = []): bool
    {
      if (!is_array($values)) {
        throw new ParamVerifyException(sprintf('Value supplied to Collection Verifier (%s) is not an array.', $this->name));
      }

      $this->subParamVerify->verify($values, $errors);

      return empty($errors);
    }
}