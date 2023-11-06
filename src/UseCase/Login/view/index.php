<?php

declare(strict_types=1);

use PHPForge\Html\Button;
use PHPForge\Html\A;
use PHPForge\Html\P;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\Tag;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use Yii\User\UseCase\Login\LoginForm;
use Yii\User\UserModule;
use yii\web\View;

/**
 * @var LoginForm $formModel
 * @var UserModule $userModule
 * @var View $this
 **/
$this->title = Yii::t('yii.user', 'Sign in');
?>

<?= Div::widget()->class('container mt-3')->begin() ?>
    <?= Div::widget()->class('row align-items-center justify-content-center')->begin() ?>
        <?= Div::widget()->class('col-md-5 col-sm-12')->begin() ?>
            <?=
                Div::widget()
                    ->class('bg-body-tertiary shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500')
                    ->begin()
            ?>
                <?= H::widget()->content(Encode::content($this->title))->class('fw-bold')->tagName('h1') ?>
                <?= P::widget()->content(Yii::t('yii.user', 'Please fill out the following fields to Sign in.')) ?>
                <?= Tag::widget()->class('mb-2')->tagName('hr') ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'login-form',
                        'layout' => $userModule->floatLabels ? ActiveForm::LAYOUT_FLOATING : ActiveForm::LAYOUT_DEFAULT,
                        'enableAjaxValidation' => true,
                    ],
                ) ?>
                    <?= $form->field($formModel, 'login')
                        ->textInput(
                            [
                                'autofocus' => true,
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Login Here') . '")',
                                'required' => true,
                                'tabindex' => '1',
                            ]
                    ) ?>
                    <?= $form->field($formModel, 'password')
                        ->passwordInput(
                            [
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here') . '")',
                                'required' => true,
                                'tabindex' => '2',
                            ],
                    ) ?>
                    <?= $form->field($formModel, 'rememberMe')
                        ->checkbox(
                            [
                                'class' => 'form-check-input',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'You must accept the terms and conditions.') . '")',
                                'tabindex' => '3',
                                'template' => "<div class=\"form-check form-switch\">\n{input}\n{label}\n{error}\n{hint}\n</div>",
                            ],
                        )
                    ?>
                    <?php if ($userModule->passwordRecovery) : ?>
                        <?=
                            Div::widget()
                                ->class('mt-3')
                                ->content(
                                    Yii::t('yii.user', 'If you forgot your password you can '),
                                    A::widget()
                                        ->content(Yii::t('yii.user', 'reset it'))
                                        ->href(Url::to(['/user/recovery/request']))
                                        ->tabIndex(4)
                                )
                        ?>
                    <?php endif ?>
                    <?=
                        Div::widget()
                            ->class('d-grid gap-2')
                            ->content(
                                Button::widget()
                                    ->class('btn btn-lg btn-primary btn-block mt-3')
                                    ->content(Yii::t('yii.user', 'Sign in'),)
                                    ->name('login-button')
                                    ->submit()
                                    ->tabIndex(5)
                        )
                    ?>
                <?php ActiveForm::end() ?>
                <?= Tag::widget()->class('mb-2')->tagName('hr') ?>
                <?php if ($userModule->confirmation) : ?>
                    <?=
                        P::widget()
                            ->class('mt-3 text-center')
                            ->content(
                                A::widget()
                                    ->content(Yii::t('yii.user', 'Didn\'t receive confirmation message?'))
                                    ->href(Url::to(['/resend/index']))
                                    ->tabIndex(6)
                            )
                    ?>
                <?php endif ?>
                <?php if ($userModule->register) : ?>
                    <?=
                        P::widget()
                            ->class('mt-3 text-center')
                            ->content(
                                A::widget()
                                    ->content(Yii::t('yii.user', 'Don\'t have an account? Sign up!'))
                                    ->href(Url::to(['/register/index']))
                                    ->tabIndex(7)
                            )
                    ?>
                <?php endif ?>
            <?= Div::end() ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();

