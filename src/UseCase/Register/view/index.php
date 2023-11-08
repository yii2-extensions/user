<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Button;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\P;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use sjaakp\icon\Icon;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii\User\UseCase\Register\RegisterForm;
use Yii\User\UserModule;
use yii\web\View;

/**
 * @var RegisterForm $formModel
 * @var UserModule $userModule
 * @var View $this
 **/
$this->title = Yii::t('yii.user', 'Sign up');
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
                <?= P::widget()->content(Yii::t('yii.user', 'Please fill out the following fields to Sign up.')) ?>
                <?= Tag::widget()->class('mb-3')->tagName('hr') ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'register-form',
                        'layout' => $userModule->floatLabels ? ActiveForm::LAYOUT_FLOATING : ActiveForm::LAYOUT_DEFAULT,
                        'enableAjaxValidation' => true,
                    ],
                ) ?>
                    <?= $form->field($formModel, 'email')
                        ->textInput(
                            [
                                'autofocus' => true,
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Email Here.') . '")',
                                'placeholder' => Yii::t('yii.user', 'Email'),
                                'required' => true,
                                'tabindex' => '1',
                            ],
                        )
                    ?>
                    <?= $form->field($formModel, 'username')
                        ->textInput(
                            [
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Username Here.') . '")',
                                'placeholder' => Yii::t('yii.user', 'Username'),
                                'required' => true,
                                'tabindex' => '2',
                            ],
                        )
                    ?>
                    <?php if ($userModule->generatePassword === false) : ?>
                        <?= $form->field($formModel, 'password')
                            ->passwordInput(
                                [
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here.') . '")',
                                    'placeholder' => Yii::t('yii.user', 'Password'),
                                    'required' => !((YII_ENV === 'tests')),
                                    'tabindex' => '3',
                                ]
                            )
                        ?>
                        <?= $form->field($formModel, 'passwordRepeat')
                            ->passwordInput(
                                [
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'Enter Password Here.') . '")',
                                    'placeholder' => Yii::t('yii.user', 'Password'),
                                    'required' => true,
                                    'tabindex' => '4',
                                ]
                            )
                        ?>
                    <?php endif ?>
                    <?= $form->field($formModel, 'accept_terms')
                        ->checkbox(
                            [
                                'class' => 'form-check-input',
                                'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.user', 'You must accept the terms and conditions.') . '")',
                                'required' => true,
                                'tabindex' => '5',
                                'template' => "<div class=\"form-check form-switch\">\n{input}\n{label}\n{error}\n{hint}\n</div>",
                            ],
                        )
                    ?>
                    <?=
                        Div::widget()
                            ->class('d-grid gap-2')
                            ->content(
                                Button::widget()
                                    ->class('btn btn-lg btn-primary btn-block mt-3')
                                    ->content(Yii::t('yii.user', 'Sign up'))
                                    ->name('register-button')
                                    ->submit()
                                    ->tabIndex(6)
                        )
                    ?>
                <?php ActiveForm::end() ?>
                <?= Tag::widget()->class('mb-3')->tagName('hr') ?>
                <?=
                    P::widget()
                        ->class('mt-3 text-center')
                        ->content(
                            A::widget()
                                ->content(Yii::t('yii.user', 'Already registered? Sign in!'))
                                ->href(Url::to(['/login/index']))
                        )
                ?>
                <?=
                    Div::widget()
                        ->class('d-flex flex-column align-items-center justify-content-center my-4')
                        ->content(
                            P::widget()
                                ->class('mt-3 text-center')
                                ->content(
                                    Span::widget()
                                        ->class('fw-bold')
                                        ->content(Yii::t('yii.user', 'Or login with:'))
                                ),
                            A::widget()
                                ->ariaLabel('github-button')
                                ->class('btn btn-icon-only btn-pill btn-outline-gray-500')
                                ->content(
                                    Span::widget()
                                        ->class('fa-stack fa-2x')
                                        ->content(
                                            Icon::renderIcon('solid', 'square-full', ['class' => 'fas fa-stack-2x']),
                                            Icon::renderIcon('brands', 'github', ['class' => 'fab fa-stack-1x fa-inverse text-center'])
                                        )
                                )
                                ->href('#')
                                ->title('Github register'),
                        )
                ?>
            <?= Div::end() ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();
