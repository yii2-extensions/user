<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Register;

use yii\base\Module;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\symfonymailer\Mailer;
use Yii\User\Service\TokenToUrl;
use Yii\User\UserModule;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

final class RegisterController extends Controller
{
    /**
     * @phpstan-var class-string<RegisterForm>
     */
    public string $formModelClass = RegisterForm::class;
    public $layout = '@resource/layout/main';
    public string $viewPath = __DIR__ . '/view';

    public function __construct(
        $id,
        Module $module,
        private readonly AjaxValidator $ajaxValidator,
        private readonly Mailer $mailer,
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

    public function actionIndex(): Response|string
    {
        $registerForm = new $this->formModelClass($this->userModule);
        $event = new RegisterEvent($registerForm, $this->userModule);

        if ($this->userModule->register === false) {
            $this->trigger(RegisterEvent::MODULE_DISABLE, $event);

            return $this->goHome();
        }

        $this->trigger(RegisterEvent::BEFORE_REGISTER, $event);
        $this->ajaxValidator->validate($registerForm);

        if (
            $this->request instanceof Request &&
            $registerForm->load($this->request->post()) &&
            $registerForm->validate()
        ) {
            $registerForm->registration_ip = $this->request->userIP;

            if ($this->registerService->run($registerForm)) {
                if ($this->userModule->confirmation) {
                    $url = Url::toRoute(
                        [
                            $this->userModule->urlConfirmation,
                            'id' => $registerForm->id,
                            'code' => $this->tokenToUrl->run(
                                $registerForm->id,
                                UserModule::TYPE_CONFIRMATION,
                            ),
                        ],
                        true,
                    );
                }

                $this->registerMailer->send(
                    $this->mailer,
                    $registerForm->email,
                    $registerForm->username,
                    $registerForm->password,
                    $url ?? null,
                );

                $this->trigger(RegisterEvent::AFTER_REGISTER, $event);
            }

            return $this->goHome();
        }

        return $this->render(
            'index',
            ['formModel' => $registerForm, 'userModule' => $this->userModule],
        );
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
