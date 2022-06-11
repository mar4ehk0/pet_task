<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $description
 * @property int|null $price
 * @property int $task_id
 * @property string $created
 *
 * @property Employee $employee
 * @property Task $task
 */
class Bid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bids';
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['user_id' => 'employee_id']);
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
