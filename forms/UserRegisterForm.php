<?php

namespace app\forms;

use app\models\City;
use app\models\User;
use app\repositories\CityRepository;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserRegisterForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $passwordRepeat = '';
    public string $birthday = '';
    public int $city_id = 0;
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository, $config = [])
    {
        $this->cityRepository = $cityRepository;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'passwordRepeat'], 'required'],
            [['email'], 'email'],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']],
            [['name', 'email', 'email'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 4, 'max' => 12],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
            ['birthday', 'guardIsUserMature', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Электронная почта',
            'birthday' => 'День рождения',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повтор Пароля',
            'city_id' => 'Город',
        ];
    }

    public function guardIsUserMature($attribute, $params, $validator)
    {
        if (!isset($this->{$attribute})) {
            return false;
        }

        $limitDate = new \DateTime();
        $limitDate->sub(new \DateInterval('P18Y'));
        $birthday = new \DateTime($this->{$attribute});
        if ($birthday > $limitDate) {
            $this->addError($attribute, 'У нас работают только совершеннолетние.');
            return false;
        }

        return true;
    }

    public function isAgeValid(): bool
    {
        $errors = $this->getErrors();
        if (isset($errors['birthday'])) {
            return false;
        }
        return true;
    }

    public function getCityList(): array
    {
        return ArrayHelper::map($this->cityRepository->findAll(), 'id', 'name');
    }


}