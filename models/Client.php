<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property int $user_id
 *
 * @property User $user
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function create(User $user): Client
    {
        $client = new self();
        $client->populateRelation('user', $user);
        return $client;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var User $user */
            if (isset($related['user']) && $user = $related['user']) {
                $user->save();
                $this->user_id = $user->id;
            }
            return true;
        }
        return false;
    }
}
