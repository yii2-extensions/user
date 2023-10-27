<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use yii\base\Event;
use yii\base\Model;
use Yii\User\UserModule;

final class LoginEvent extends Event
{
    public const AFTER_LOGIN = 'afterLogin';
    public const BEFORE_LOGIN = 'beforeLogin';

    public function __construct(
        public readonly Model $model,
        public readonly UserModule $userModule,
        array $config = []
    )
    {
        parent::__construct($config);
    }
}
