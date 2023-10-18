<?php

declare(strict_types=1);

use yii\bootstrap5\Html;

/**
 * @var bool $showPassword
 * @var string $password
 * @var string $username
 * @var string|null $url
 */
?>
<p>
    <?= Yii::t('yii.user', 'Hello') ?>,
</p>

<p>
    <?= Yii::t('yii.user', 'Your account on {0} has been created.', [Yii::$app->name]) ?>

    <?php if ($showPassword): ?>
        <br/>
        <br/>
        <?= Yii::t('yii.user', 'We have generated a password for you') ?>: <strong><?= $password ?></strong>
    <?php endif ?>
</p>

<?php if ($url !== null): ?>
    <p>
        <?= Yii::t('yii.user', 'In order to complete your registration, please click the link below.') ?>
    </p>
    <p>
        <?= Html::a(Html::encode($url), $url); ?>
    </p>
    <p>
        <?= Yii::t('yii.user', 'If you cannot click the link, please try pasting the text into your browser.') ?>
    </p>
<?php endif ?>
<br/>
