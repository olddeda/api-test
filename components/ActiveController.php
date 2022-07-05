<?php

namespace app\components;

use yii\rest\ActiveController as BaseController;
use yii\filters\auth\HttpBearerAuth;

class ActiveController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
        ];
    }
}