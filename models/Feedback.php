<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedbacks".
 *
 * @property int $id
 * @property string $feedback
 * @property int $grade
 * @property int $task_id
 * @property string $created
 *
 * @property Task $task
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedbacks';
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
