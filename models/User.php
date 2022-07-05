<?php
namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

use app\enum\UserStatus;
use app\models\query\UserQuery;

/**
 * User model.
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var string|null */
    public ?string $password = null;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['username', 'email', 'password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'length' => 32],
            ['username', 'match', 'pattern' => '/[A-z0-9_-]/'],
            ['username', 'string', 'min' => 2, 'max' => 64],
            ['username', 'unique'],
            ['email', 'email'],
            ['email', 'unique'],
            ['password', 'string', 'min' => 6],
            ['status', 'in', 'range' => array_map(function ($e) {
                return $e->value;
            }, UserStatus::cases())],
        ];
    }

    /**
     * @return UserQuery
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id): ?User
    {
        return self::find()
            ->active()
            ->andWhere('id = :id', [
                'id' => $id,
            ])
            ->one()
        ;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return self::find()
            ->active()
            ->andWhere('auth_key = :token', [
                'token' => $token,
            ])
            ->one()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(): bool|int
    {
        $this->status = UserStatus::DELETED->value;
        return $this->save();
    }


    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->status = UserStatus::ACTIVE->value;
        }

        if (!is_null($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }
}
