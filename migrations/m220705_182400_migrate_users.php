<?php

use \yii\db\Migration;
use \yii\base\Exception;

use app\enum\UserStatus;

class m220705_182400_migrate_users extends Migration
{
    /**
     * @throws Exception
     */
    public function safeUp()
    {
        $security = Yii::$app->security;
        $time = time();

        $this->db->createCommand()->batchInsert('{{%user}}', [
            'username',
            'email',
            'auth_key',
            'password_hash',
            'status',
            'created_at',
            'updated_at',
        ], [
            [
                'admin',
                'admin@host.com',
                $security->generateRandomString(),
                $security->generatePasswordHash('admin'),
                UserStatus::ACTIVE->value,
                $time,
                $time,
            ],
            [
                'user',
                'user@host.com',
                $security->generateRandomString(),
                $security->generatePasswordHash('user'),
                UserStatus::ACTIVE->value,
                $time,
                $time,
            ],
            [
                'deleted',
                'deleted@host.com',
                $security->generateRandomString(),
                $security->generatePasswordHash('deleted'),
                UserStatus::DELETED->value,
                $time,
                $time,
            ],
        ])->execute();
    }

    public function safeDown()
    {
        $this->delete('{{%user}}');
    }
}