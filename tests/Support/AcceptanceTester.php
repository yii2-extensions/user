<?php

declare(strict_types=1);

namespace Yii\User\Tests\Support;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */
    public function accountConfirmation(bool $option): void
    {
        \Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'confirmation' => $option,
                ],
            ],
        );
    }

    public function accountGeneratePassword(bool $option): void
    {
        \Yii::$container->set(
            \Yii\User\UserModule::class,
            [
                '__construct()' => [
                    'generatePassword' => $option,
                ],
            ],
        );
    }
}
