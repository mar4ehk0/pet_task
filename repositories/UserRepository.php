<?php

namespace app\repositories;

use app\models\User;
use app\repositories\exceptions\NotFoundException;

class UserRepository
{
    public function find(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $user;
    }

    public function findByEmail(string $email): User
    {
        if (!$user = User::find()->where(['email' => $email])->one()) {
            throw new NotFoundException('Model not found.');
        }
        return $user;
    }

    public function add(User $user): bool
    {
        if (!$user->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }

        $user->password = $this->setPassword($user->password);

        if (!$user->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function save(User $user): bool
    {
        if ($user->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($user->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }

    public function delete(User $user): bool
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

        return true;
    }

    private function setPassword($password): string
    {
        return \Yii::$app->security->generatePasswordHash($password);
    }
}
