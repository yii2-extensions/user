<?php

declare (strict_types=1);

namespace Yii\User\UseCase\Login;

use yii\base\Module;
use yii\filters\AccessControl;
use Yii\User\Framework\Repository\FinderAccountRepository;
use Yii\User\Model\Account;
use Yii\User\UseCase\Controller;
use Yii\User\UserModule;
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
        private readonly FinderAccountRepository $finderAccountRepository,
        private readonly PasswordHasher $passwordHasher,
        private readonly User $user,
        private readonly UserModule $userModule,
        private readonly LoginService $loginService,
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
                'denyCallback' => function () {
                    if ($this->user->getIsGuest() === false) {
                        return $this->goHome();
                    }
                },
            ],
        ];
    }

    public function actionIndex(): Response|string
    {
        $account = null;

        if ($this->request->getIsPost() === true && $this->request->post('LoginForm') !== null) {
            $login = $this->request->post('LoginForm')['login'] ?? '';
            /** @var Account|null $account */
            $account = $this->finderAccountRepository->findByUsernameOrEmail($login);
        }

        $loginForm = new $this->formModelClass($account, $this->passwordHasher, $this->userModule);
        $event = new LoginEvent($loginForm, $this->userModule);

        $this->trigger(LoginEvent::BEFORE_LOGIN, $event);
        $this->performAjaxValidation($loginForm);

        if (
            $loginForm->load($this->request->post()) &&
            $loginForm->validate() &&
            $this->loginService->run($account, $loginForm->autoLogin())
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
