<?php

namespace app\models\buttons\actions;

use app\models\Bid;
use app\repositories\TaskRepository;

class StartTaskAction extends AbstractTaskAction
{

    private Bid $bid;

    public function __construct(Bid $bid, TaskRepository $taskRepository)
    {
        parent::__construct($taskRepository);
        $this->bid = $bid;
    }


    protected function getTaskId(): int
    {
        return $this->bid->task_id;
    }

    protected function action(): void
    {
        $this->task->start($this->bid->employee_id);
    }
}