<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;

use app\components\ActiveController;

use app\modules\v1\models\User;

class UserController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public $modelClass = User::class;

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        $actions = parent::actions();

        $actions['index']['prepareSearchQuery'] = function ($query, $requestParams) {
            return $query->active();
        };
        $actions['view']['findModel'] = [$this, 'findModel'];
        $actions['create']['scenario'] = User::SCENARIO_CREATE;
        $actions['update']['scenario'] = User::SCENARIO_UPDATE;

        return $actions;
    }

    /**
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): User
    {
        $model = User::find()
            ->active()
            ->where('id = :id', [
                'id' => $id,
            ])
            ->one()
        ;

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('user', 'not_found'));
        }

        return $model;
    }
}