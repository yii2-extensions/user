<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Logout;

use yii\base\Event;
use yii\base\Model;
use Yii\User\UserModule;

final class LogoutEvent extends Event
{
    public const AFTER_LOGOUT = 'afterLogout';
    public const BEFORE_LOGOUT = 'beforeLogout';

    public function __construct(public readonly UserModule $userModule, array $config = [])
    {
        parent::__construct($config);
    }
}
