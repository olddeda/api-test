<?php

namespace app\components;

use Yii;
use yii\web\ErrorAction as BaseAction;

class ErrorAction extends BaseAction
{
    /**
     * @inheritdoc
     */
    public function run(): array
    {
        Yii::$app->getResponse()->setStatusCodeByException($this->exception);
        return $this->getViewRenderParams();
    }
}