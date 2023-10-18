<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\symfonymailer\Mailer;
use Yii\User\Framework\Event\FormEvent;
use Yii\User\Service\TokenToUrl;
use Yii\User\UseCase\Controller;
use Yii\User\UserModule;
use yii\web\Request;

final class RegisterController extends Controller
{
    public $layout = '@resource/layout/main';

    public function __construct(
        $id,
        Module $module,
        private readonly Mailer $mailer,
        private readonly RegisterForm $registerForm,
        private readonly RegisterMailer $registerMailer,
        private readonly RegisterService $registerService,
        private readonly TokenToUrl $tokenToUrl,
        private readonly UserModule $userModule,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $event = new FormEvent($this->registerForm);

        $this->trigger(FormEvent::BEFORE_REGISTER, $event);
        $this->performAjaxValidation($this->registerForm);

        if (
            $this->request instanceof Request &&
            $this->registerForm->load($this->request->post()) &&
            $this->registerForm->validate()
        ) {
            $this->registerForm->registration_ip = $this->request->userIP;

            if ($this->registerService->run($this->registerForm)) {
                if ($this->userModule->confirmation) {
                    $url = Url::toRoute(
                        [
                            $this->userModule->urlConfirmation,
                            'id' => $this->registerForm->id,
                            'code' => $this->tokenToUrl->run(
                                $this->registerForm->id,
                                UserModule::TYPE_CONFIRMATION,
                            ),
                        ],
                        true,
                    );
                }

                $this->registerMailer->send(
                    $this->mailer,
                    $this->registerForm->email,
                    $this->registerForm->username,
                    $this->registerForm->password,
                    $url ?? null,
                );

                $this->trigger(FormEvent::AFTER_REGISTER, $event);
            }

            return $this->goHome();
        }

        return $this->render(
            'index',
            ['registerForm' => $this->registerForm, 'userModule' => $this->userModule],
        );
    }

    public function getViewPath(): string
    {
        return __DIR__ . '/view';
    }
}
