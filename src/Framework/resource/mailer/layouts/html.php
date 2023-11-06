<?php

declare(strict_types=1);

use PHPForge\Html\Img;
use yii\base\View;
use yii\mail\MessageInterface;

/**
 * @var string $content
 * @var MessageInterface $message
 * @var string $signatureText
 * @var View $this
 */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns = 'http://www.w3.org/1999/xhtml'>
        <head>
            <meta name = 'viewport' content = 'width=device-width'>
            <meta http-equiv = 'Content-Type' content = 'text/html;charset=UTF-8'>
        </head>
        <body>
            <?= $content ?>
            <div>
                <?= Img::widget()->alt('Mailer logo')->src($message->embed($this->params['logo']))->width('40px') ?>
                <br/>
                <strong>
                    <?= $this->params['signatureText'] ?>
                </strong>
            </div>
        </body>
    </html>
<?php $this->endPage();
