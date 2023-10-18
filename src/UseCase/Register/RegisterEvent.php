<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use yii\base\Event;
use Yii\User\UserModule;

final class RegisterEvent extends Event
{
    public const AFTER = 'after';
    public const BEFORE = 'before';

    public function __construct(public readonly UserModule $userModule, array $config = [])
    {
        parent::__construct($config);
    }
}
