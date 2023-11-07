<?php

declare(strict_types=1);

namespace Yii\User\Tests\Support\Data\Fixture;

use yii\test\ActiveFixture;
use Yii\User\ActiveRecord\Identity;

final class IdentityFixture extends ActiveFixture
{
    /**
     * @phpstan-var class-string<Identity> $modelClass
     */
    public $modelClass = Identity::class;
    public $dataFile = __DIR__ . '/IdentityData.php';
}
