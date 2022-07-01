<?php

namespace app\models;

use app\services\dto\UserDTO;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $birthday
 * @property int $city_id
 * @property string $avatar
 * @property string $created
 *
 * @property Client $client
 * @property Employee $employee
 * @property City $city
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function validatePassword($password): bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function create(UserDTO $userDTO): User
    {
        $user = new self();
        $user->email = $userDTO->email;
        $user->name = $userDTO->name;
        $user->password = $userDTO->password;
        $user->birthday = $userDTO->birthday;
        $user->city_id = $userDTO->city_id;
        $user->created = (new \DateTime())->format('Y-m-d H:i:s');
        return $user;
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['user_id' => 'id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['user_id' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function isEmployee(): bool
    {
        if (empty($this->employee)) {
            return false;
        }
        return true;
    }
}
