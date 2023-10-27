<?php

declare (strict_types=1);

namespace Yii\User\UseCase\Logout;

use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii\User\UserModule;
use yii\web\Controller;
use yii\web\Response;

final class LogoutController extends Controller
{
    public $layout = '@resource/layout/main';

    public function __construct(
        $id,
        Module $module,
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
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST'],
                ],
            ],

        ];
    }

    public function actionIndex(): Response|string
    {
        $event = new LogoutEvent($this->userModule);

        $this->trigger(LogoutEvent::BEFORE_LOGOUT, $event);

        $this->module->user->logout();

        $this->trigger(LogoutEvent::AFTER_LOGOUT, $event);

        return $this->goHome();
    }
}
