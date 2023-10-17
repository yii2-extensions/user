<?php

declare(strict_types=1);

use sjaakp\icon\Icon;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use Yii\User\UseCase\Register\RegisterForm;
use Yii\User\UserModule;
use yii\web\View;

/**
 * @var RegisterForm $registerForm
 * @var UserModule $userModule
 * @var View $this
 **/
$this->title = Yii::t('yii.user', 'Sign up');
?>
<?= Html::beginTag('div', ['class' => 'container mt-3']) ?>
    <?= Html::beginTag('div', ['class' => 'row align-items-center justify-content-center']) ?>
        <?= Html::beginTag('div', ['class' => 'col-md-5 col-sm-12']) ?>
            <?= Html::beginTag(
                'div',
                ['class' => 'bg-body-tertiary shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500'],
            ) ?>
                <?= Html::tag('h1', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-registration-register-title']) ?>
                <?= Html::beginTag('p', ['class' => 'form-registration-register-subtitle']) ?>
                    <?= Yii::t(
                        'yii.user',
                        'Please fill out the following fields to Sign up.'
                    ) ?>
                <?= Html::endTag('p') ?>
                <?= Html::tag('hr', '', ['class' => 'mb-3']) ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'register-form',
                        'layout' => 'default',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'error' => 'text-center',
                                'field' => 'form-floating',
                            ],
                            'options' => ['class' => 'form-floating mb-4'],
                            'template' => ($userModule->floatLabels) ?
                                '{input}{label}{hint}{error}' :
                                '<div>{label}{input}{hint}{error}</div>',
                        ],
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ],
                ) ?>
                    <?= $form->field($registerForm, 'email')
                        ->textInput(
                            [
                                'autofocus' => true,
                                'oninput' => 'this.setCustomValidity("")',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Email Here') . '")',
                                'placeholder' => Yii::t('yii.user', 'Email'),
                                'required' => (YII_ENV === 'test') ? false : true,
                                'tabindex' => '1',
                            ],
                        )
                    ?>
                    <?= $form->field($registerForm, 'username')
                        ->textInput(
                            [
                                'oninput' => 'this.setCustomValidity("")',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Username Here') . '")',
                                'placeholder' => Yii::t('yii.user', 'Username'),
                                'required' => (YII_ENV === 'test') ? false : true,
                                'tabindex' => '2',
                            ],
                        )
                    ?>
                    <?php if ($userModule->accountGeneratingPassword === false) : ?>
                        <?= $form->field($registerForm, 'password')
                            ->passwordInput(
                                [
                                    'oninput' => 'this.setCustomValidity("")',
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here') . '")',
                                    'placeholder' => Yii::t('yii.user', 'Password'),
                                    'required' => (YII_ENV === 'test') ? false : true,
                                    'tabindex' => '3',
                                ]
                            )
                        ?>
                        <?= $form->field($registerForm, 'passwordRepeat')
                            ->passwordInput(
                                [
                                    'oninput' => 'this.setCustomValidity("")',
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here') . '")',
                                    'placeholder' => Yii::t('yii.user', 'Password'),
                                    'required' => (YII_ENV === 'test') ? false : true,
                                    'tabindex' => '4',
                                ]
                            )
                        ?>
                    <?php endif ?>
                    <?= Html::beginTag('div', ['class' => 'd-grid gap-2']) ?>
                        <?= Html::submitButton(
                            Yii::t('yii.user', 'Sign up'),
                            [
                                'class' => 'btn-block btn btn-lg btn-primary mt-3',
                                'id' => 'register-button',
                                'tabindex' => '5'
                            ],
                        ) ?>
                    <?= Html::endTag('div') ?>
                <?php ActiveForm::end() ?>
                <?= Html::tag('hr', '', ['class' => 'mb-2']) ?>
                <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
                    <?= Html::a(Yii::t('yii.user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                <?= Html::endTag('p') ?>
                <div class="d-flex flex-column align-items-center justify-content-center my-4">
                    <?= Html::beginTag('p', ['class' => 'mt-3 text-center']) ?>
                        <?= Html::tag('span', '<strong>' . Yii::t('yii.user', 'Or login with:') . '</strong>') ?>
                    <?= Html::endTag('p') ?>
                    <?= Html::beginTag(
                        'a',
                        [
                            'aria-label' => 'github-button',
                            'class' => 'btn btn-icon-only btn-pill btn-outline-gray-500',
                            'href' => '#',
                            'title' => 'Github register',
                        ]
                    ) ?>
                        <?= Html::beginTag('span', ['class' => 'fa-stack fa-2x']) ?>
                            <?= Icon::renderIcon('solid', 'square-full', ['class' => 'fas fa-stack-2x']) ?>
                            <?= Icon::renderIcon('brands', 'github', ['class' => 'fab fa-stack-1x fa-inverse text-center']) ?>
                        <?= Html::endTag('span') ?>
                    <?= Html::endTag('a') ?>
                <?= Html::endTag('div') ?>
            <?= Html::endTag('div') ?>
        <?= Html::endTag('div') ?>
    <?= Html::endTag('div') ?>
<?= Html::endTag('div');
