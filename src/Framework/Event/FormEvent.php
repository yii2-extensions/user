<?php

declare(strict_types=1);

namespace Yii\User\Framework\Event;

use yii\base\Event;
use yii\base\Model;

final class FormEvent extends Event
{
    final public const AFTER_REGISTER = 'afterRegister';
    final public const BEFORE_REGISTER = 'beforeRegister';

    public function __construct(public readonly Model $form, array $config = [])
    {
        parent::__construct($config);
    }
}
