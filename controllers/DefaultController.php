<?php

namespace app\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
             'error' => [
                'class' => 'app\components\ErrorAction',
             ],
        ];
    }
}