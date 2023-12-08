<?php

declare(strict_types=1);

namespace Yii\User\UseCase\Login;

use yii\base\Module;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\filters\AccessControl;
use Yii\User\ActiveRecord\Account;
use Yii\User\Framework\Repository\FinderAccountRepository;
use Yii\User\UserModule;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;
use Yiisoft\Security\PasswordHasher;

final class LoginController extends Controller
{
    /**
     * @phpstan-var class-string<LoginForm>
     */
    public string $formModelClass = LoginForm::class;
    public $layout = '@resource/layout/main';
    public string $viewPath = __DIR__ . '/view';

    public function __construct(
        $id,
        Module $module,
        private readonly Account $account,
        private readonly AjaxValidator $ajaxValidator,
        private readonly FinderAccountRepository $finderAccountRepository,
        private readonly LoginService $loginService,
        private readonly PasswordHasher $passwordHasher,
        private readonly User $user,
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
        if ($this->user->getIsGuest() === false) {
            return $this->goHome();
        }

        $loginForm = new $this->formModelClass(
            $this->account,
            $this->finderAccountRepository,
            $this->passwordHasher,
            $this->userModule,
        );
        $event = new LoginEvent($loginForm, $this->userModule);

        if ($this->userModule->allowLogin === false && $this->userModule->allowLoginByIPs === []) {
            $this->trigger(LoginEvent::MODULE_DISABLE, $event);

            return $this->goHome();
        }

        if ($this->userModule->allowLoginByIPs !== [] && !$this->loginService->checkAllowedIp($this->request->userIP)) {
            $this->trigger(LoginEvent::IP_NOT_ALLOWED, $event);

            return $this->goHome();
        }

        $this->trigger(LoginEvent::BEFORE_LOGIN, $event);
        $this->ajaxValidator->validate($loginForm);

        if (
            $this->request instanceof Request &&
            $loginForm->load($this->request->post()) &&
            $loginForm->validate() &&
            $this->loginService->run($loginForm)
        ) {
            $this->trigger(LoginEvent::AFTER_LOGIN, $event);

            return $this->goHome();
        }

        return $this->render(
            'index',
            ['formModel' => $loginForm, 'userModule' => $this->userModule],
        );
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
