<?php

namespace app\forms;

use app\models\Task;

class CreateBidForm extends AbstractForm
{
    public int $employee_id;
    public string $description = '';
    public string $price = '';
    public int $task_id;

    public function __construct(int $employee_id, int $task_id, $config = [])
    {
        parent::__construct($config);
        $this->employee_id = $employee_id;
        $this->task_id = $task_id;
    }

    public function rules()
    {
        return [
            [['description'], 'required'],
            [['employee_id', 'task_id'], 'integer'],
            ['price', 'guardIsValidPrice', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'description' => 'Ваша предложение',
            'price' => 'Ваша цена',
        ];
    }

    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getTaskId(): int
    {
        return $this->task_id;
    }


}