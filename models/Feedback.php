<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedbacks".
 *
 * @property int $id
 * @property string $body
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

    public static function create(string $body, int $grade, int $task_id): self
    {
        $feedback = new self();
        $feedback->body = $body;
        $feedback->grade = $grade;
        $feedback->task_id = $task_id;
        $feedback->created = (new \DateTime())->format('Y-m-d H:i:s');
        return $feedback;
    }
}
