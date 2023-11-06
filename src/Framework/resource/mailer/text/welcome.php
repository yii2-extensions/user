<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Helper\Encode;

/**
 * @var bool $showPassword
 * @var string $password
 * @var string $username
 * @var string|null $url
 */
?>
<?= Yii::t('yii.user', 'Hello') ?>,
<?= Yii::t('yii.user', 'Your account on {0} has been created.', [Yii::$app->name]) ?>

<?php if ($showPassword): ?>
    <?= Yii::t('yii.user', 'We have generated a password for you') ?>: <strong><?= $password ?></strong>
<?php endif ?>

<?php if ($url !== null): ?>
    <?= Yii::t('yii.user', 'In order to complete your registration, please click the link below.') ?>
    <?= A::widget()->content(Encode::content($url))->href($url) ?>
    <?= Yii::t('yii.user', 'If you cannot click the link, please try pasting the text into your browser.') ?>
<?php endif ?>
<br/>
