<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use yii\base\Event;

final class RegisterEvent extends Event
{
    public const AFTER = 'after';
    public const BEFORE = 'before';

    public function __construct(public readonly bool $confirmation, array $config = [])
    {
        parent::__construct($config);
    }
}
