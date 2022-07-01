<?php

namespace app\forms;

class EmployeeRegisterForm extends UserRegisterForm
{
    public string $about = '';
    public string $phone = '';
    public string $telegram = '';

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['about', 'phone'], 'required'];
        $rules[] = [['telegram'], 'string', 'max' => 64];
        return $rules;
    }

    public function attributeLabels()
    {
        $attr = parent::attributeLabels();
        return array_merge(
            $attr,
            [
                'about' => 'О вас',
                'phone' => 'Номер телефона',
                'telegram' => 'мессенджер-телеграм',
            ]
        );
    }
}
