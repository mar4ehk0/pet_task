<?php

namespace app\forms;

use app\helpers\TaskView;
use app\models\Employee;
use app\models\Task;
use app\repositories\TaskRepository;

class FeedbackForm extends AbstractForm
{
    public string $body = '';
    public int $grade = 0;
    public Task $task;
    public TaskView $taskView;
    public Employee $employee;

    public function __construct(int $task_id)
    {
        parent::__construct();
        $taskRepository = new TaskRepository();
        $this->task = $taskRepository->find($task_id);
        $this->employee = $this->task->employee;
        $this->taskView = new TaskView($this->task);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body', 'grade'], 'required'],
            [['body'], 'string'],
            [['grade'], 'integer', 'min' => 1, 'max' => 5],
//            [['task_id'],
//                'exist',
//                'skipOnError' => true,
//                'targetClass' => Task::class,
//                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'body' => 'Отзыв',
            'grade' => 'Оценка',
        ];
    }
}
