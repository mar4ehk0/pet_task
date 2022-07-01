<?php

namespace app\models;

use app\services\dto\TaskAddressDTO;
use app\services\dto\TaskRequiredPropertiesDTO;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $client_id
 * @property int|null $employee_id
 * @property int|null $city_id
 * @property string|null $location
 * @property string|null $address
 * @property string|null $lat
 * @property string|null $long
 * @property int $is_remote
 * @property int|null $price
 * @property string $deadline
 * @property int $status
 * @property string $created
 *
 * @property Category $category
 * @property City $city
 * @property Client $client
 * @property Employee $employee
 */
class Task extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 0;
    public const STATUS_CANCELED = 1;
    public const STATUS_IN_WORK = 2;
    public const STATUS_COMPLETED = 3;
    public const STATUS_FAILED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    public static function createRemote(TaskRequiredPropertiesDTO $dto): Task
    {
        $task = new self();
        $task->title = $dto->title;
        $task->description = $dto->description;
        $task->category_id = $dto->category_id;
        $task->client_id = $dto->client_id;
        $task->employee_id = null;
        $task->price = $dto->price;
        $task->deadline = $dto->deadline;
        $task->is_remote = $dto->is_remote;
        $task->status = self::STATUS_NEW;
        $task->created = (new \DateTime())->format('Y-m-d H:i:s');
        return $task;
    }

    public static function createDirect(
        TaskRequiredPropertiesDTO $taskRequiredPropertiesDTO,
        TaskAddressDTO $directTaskDTO
    ): Task {
        $task = self::createRemote($taskRequiredPropertiesDTO);
        $task->location = $directTaskDTO->location;
        $task->address = $directTaskDTO->address;
        $task->city_id = $directTaskDTO->city_id;
        $task->lat = $directTaskDTO->lat;
        $task->long = $directTaskDTO->long;

        return $task;
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['task_id' => 'id']);
    }
}
