<?php

namespace app\models\buttons\actions;

use app\repositories\TaskRepository;

class CancelTaskAction extends AbstractTaskAction
{
    private int $task_id;

    public function __construct(int $task_id, TaskRepository $taskRepository)
    {
        $this->task_id = $task_id;
        parent::__construct($taskRepository);
    }

    protected function getTaskId(): int
    {
        return $this->task_id;
    }

    protected function action(): void
    {
        $this->task->cancel();
    }
}
