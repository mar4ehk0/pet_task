<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $path
 * @property int $client_id
 * @property int $task_id
 * @property string $created
 * @property int $size
 *
 * @property Task $task
 * @property User $user
 */
class File extends \yii\db\ActiveRecord
{
    public const PATH_UPLOADS = 'uploads';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    public static function create(Task $task, string $name, string $extension, int $client_id, int $size): File
    {
        $file = new self();
        $file->populateRelation('task', $task);
        $file->name = $name;
        $file->extension = $extension;
        $file->path = self::PATH_UPLOADS;
        $file->client_id = $client_id;
        $file->created = (new \DateTime())->format('Y-m-d');
        $file->size = $size;
        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'extension', 'path', 'client_id', 'task_id', 'created', 'size'], 'required'],
            [['client_id', 'task_id', 'size'], 'integer'],
            [['name', 'extension', 'path'], 'string', 'max' => 255],
            [['name', 'extension', 'task_id'], 'unique', 'targetAttribute' => ['name', 'extension', 'task_id']],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']],
            [['client_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Client::class,
                'targetAttribute' => ['client_id' => 'id']],
            ['created', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'extension' => 'Extensions',
            'path' => 'Path',
            'client_id' => 'User ID',
            'task_id' => 'Task ID',
            'created' => 'Created',
            'size' => 'Size',
        ];
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

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var Task $task */
            if (isset($related['task']) && $task = $related['task']) {
                $task->save();
                $this->task_id = $task->id;
            }
            return true;
        }
        return false;
    }
}
