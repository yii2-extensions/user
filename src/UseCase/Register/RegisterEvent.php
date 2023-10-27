<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use yii\base\Event;
use yii\base\Model;
use Yii\User\UserModule;

final class RegisterEvent extends Event
{
    public const AFTER_REGISTER = 'afterRegister';
    public const BEFORE_REGISTER = 'beforeRegister';

    public function __construct(
        public readonly Model $formModel,
        public readonly UserModule $userModule,
        array $config = []
    ) {
        parent::__construct($config);
    }
}
