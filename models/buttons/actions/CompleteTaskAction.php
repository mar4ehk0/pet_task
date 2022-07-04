<?php

namespace app\models\buttons\actions;

use app\models\Feedback;
use app\repositories\TaskRepository;

class CompleteTaskAction extends AbstractTaskAction
{

    private Feedback $feedback;

    public function __construct(Feedback $feedback, TaskRepository $taskRepository)
    {
        parent::__construct($taskRepository);
        $this->feedback = $feedback;
    }

    protected function getTaskId(): int
    {
        return $this->feedback->task_id;
    }

    protected function action(): void
    {
        $this->task->complete();
    }
}