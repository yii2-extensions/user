<?php

declare(strict_types=1);

namespace Yii\User\Tests\Support\Data;

use yii\test\ActiveFixture;
use Yii\User\ActiveRecord\Account;

final class AccountFixture extends ActiveFixture
{
    /**
     * @phpstan-var class-string<Account> $modelClass
     */
    public $modelClass = Account::class;
    public $dataFile = __DIR__ . '/AccountData.php';
    public $depends = [
        IdentityFixture::class,
    ];
}
