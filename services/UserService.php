<?php

namespace app\services;

use app\models\User;
use app\repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private User $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(string $email): bool
    {
        return \Yii::$app->user->login($this->getUser($email), 3600 * 24 * 30);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User
     */
    private function getUser(string $email): User
    {
        if (empty($this->user)) {
            $this->user = $this->userRepository->findByEmail($email);
        }

        return $this->user;
    }
}
