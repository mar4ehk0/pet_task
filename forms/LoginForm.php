<?php

namespace app\forms;

use app\models\User;
use app\repositories\UserRepository;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, $config = [])
    {
        $this->userRepository = $userRepository;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->userRepository->findByEmail($this->email);

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный e-mail или пароль.');
            }
        }
    }

}
