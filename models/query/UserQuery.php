<?php

namespace app\models\query;

use yii\db\ActiveQuery;

use app\enum\UserStatus;

class UserQuery extends ActiveQuery
{
    /**
     * @return ActiveQuery
     */
    public function active(): ActiveQuery
    {
        return $this->andWhere(['status' => UserStatus::ACTIVE->value]);
    }

    /**
     * @return ActiveQuery
     */
    public function deleted(): ActiveQuery
    {
        return $this->andWhere(['status' => UserStatus::DELETED->value]);
    }
}