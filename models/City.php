<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property string $name
 * @property string $lat
 * @property string $long
 *
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lat', 'long'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['lat', 'long'], 'string', 'max' => 100],
            [['name', 'lat', 'long'], 'unique', 'targetAttribute' => ['name', 'lat', 'long']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'lat' => 'Широта',
            'long' => 'Долгота',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['city_id' => 'id']);
    }
}
