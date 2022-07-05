<?php

namespace app\modules\v1\models;

use app\models\User as BaseModel;

class User extends BaseModel
{
    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'username',
            'email',
        ];
    }
}