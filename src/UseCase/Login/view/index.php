<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
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

<?= Html::beginTag('div', ['class' => 'container mt-3']) ?>
    <?= Html::beginTag('div', ['class' => 'row align-items-center justify-content-center']) ?>
        <?= Html::beginTag('div', ['class' => 'col-md-5 col-sm-12']) ?>
            <?= Html::beginTag(
                'div',
                ['class' => 'bg-body-tertiary shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500'],
            ) ?>
                <?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-security-login-title']) ?>
                <?= Html::beginTag('p', ['class' => 'form-security-login-subtitle']) ?>
                    <?= Yii::t('yii.user', 'Please fill out the following fields to Sign in.') ?>
                <?= Html::endTag('p') ?>
                <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'login-form',
                        'layout' => $userModule->floatLabels ? ActiveForm::LAYOUT_FLOATING : ActiveForm::LAYOUT_DEFAULT,
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ],
                ) ?>
                    <?= $form->field($formModel, 'login')
                        ->textInput(
                            [
                                'autofocus' => true,
                                'oninput' => 'this.setCustomValidity("")',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Login Here') . '")',
                                'required' => !((YII_ENV === 'tests')),
                                'tabindex' => '1',
                            ]
                    ) ?>
                    <?= $form->field($formModel, 'password')
                        ->passwordInput(
                            [
                                'oninput' => 'this.setCustomValidity("")',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here') . '")',
                                'required' => !((YII_ENV === 'tests')),
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
                    <?= Html::beginTag('div', ['class' => 'form-security-recovery-password']) ?>
                        <?php if ($userModule->passwordRecovery) : ?>
                            <?= Yii::t(
                                'yii.user',
                                'If you forgot your password you can'
                            ) . ' ' .
                            Html::a(
                                Yii::t('yii.user', 'reset it here'),
                                ['/user/recovery/request']
                            ) ?>
                        <?php endif ?>
                    <?= Html::endTag('div') ?>
                    <?= Html::beginTag('div', ['class' => 'd-grid gap-2']) ?>
                        <?= Html::submitButton(
                            Yii::t('yii.user', 'Sign in'),
                            [
                                'class' => 'btn-block btn btn-lg btn-primary mt-3',
                                'id' => 'register-button',
                                'tabindex' => '4'
                            ],
                        ) ?>
                    <?= Html::endTag('div') ?>
                <?php ActiveForm::end() ?>
                <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>
                <?php if ($userModule->confirmation) : ?>
                    <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
                        <?= Html::a(
                            Yii::t(
                                'yii.user',
                                'Didn\'t receive confirmation message?'
                            ),
                            ['/user/registration/resend']
                         ) ?>
                    <?= Html::endTag('p') ?>
                <?php endif ?>
                <?php if ($userModule->register) : ?>
                    <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
                        <?= Html::a(Yii::t('yii.user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                    <?= Html::endTag('p') ?>
                <?php endif ?>
            <?= Html::endTag('div') ?>
        <?= Html::endTag('div') ?>
    <?= Html::endTag('div') ?>
<?= Html::endTag('div');

