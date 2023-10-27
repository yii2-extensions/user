<?php

declare(strict_types=1);

namespace Yii\User\UseCase;

use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveForm;
use yii\web\Request;
use yii\web\Response;

class Controller extends \yii\web\Controller
{
    protected function performAjaxValidation(Model $model)
    {
        if (
            $this->request instanceof Request &&
            $this->response instanceof Response &&
            $this->request->isAjax &&
            $model->load($this->request->post())
        ) {
            $this->response->format = Response::FORMAT_JSON;
            $this->response->data = ActiveForm::validate($model);
            $this->response->send();

            Yii::$app->end();
        }
    }
}
